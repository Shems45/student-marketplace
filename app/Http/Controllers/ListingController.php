<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Tag;
use App\Services\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function __construct(private GeocodingService $geocoding)
    {
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');
        $tagId = $request->query('tag');
        $searchCity = trim((string) $request->query('city'));
        $searchZip = trim((string) $request->query('postcode'));
        $radiusInput = $request->query('radius');
        $allowedRadii = [5, 10, 25, 50];
        $radiusKm = in_array((int) $radiusInput, $allowedRadii, true) ? (int) $radiusInput : null;

        $listingsQuery = Listing::query()
            ->where('is_sold', false) // Hide sold listings by default
            ->with(['category', 'user', 'tags'])
            ->when($q, fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            }))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($tagId, fn ($query) => $query->whereHas('tags', fn ($t) => $t->where('tags.id', $tagId)));

        // Distance filtering: fetch all candidates and filter in PHP
        if ($searchCity && $searchZip && $radiusKm) {
            $coords = $this->geocoding->geocode($searchZip, $searchCity);

            if ($coords) {
                $searchLat = $coords['lat'];
                $searchLng = $coords['lng'];

                // Fetch all listings with coordinates
                $allListings = $listingsQuery
                    ->whereNotNull('lat')
                    ->whereNotNull('lng')
                    ->latest()
                    ->get();

                // Calculate distance for each and filter
                $filteredListings = $allListings
                    ->map(function (Listing $listing) use ($searchLat, $searchLng) {
                        $listing->distance_km = $this->haversineDistance(
                            $searchLat,
                            $searchLng,
                            $listing->lat,
                            $listing->lng
                        );
                        return $listing;
                    })
                    ->filter(fn (Listing $l) => $l->distance_km <= ($this->getRadiusFromRequest() ?? 50))
                    ->sortBy('distance_km')
                    ->values();

                // Manual pagination with LengthAwarePaginator
                $page = request('page', 1);
                $perPage = 12;
                $total = $filteredListings->count();
                $items = $filteredListings
                    ->slice(($page - 1) * $perPage, $perPage)
                    ->values();

                // Return LengthAwarePaginator (has total() method)
                $listings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $page,
                    [
                        'path' => route('listings.index'),
                        'query' => request()->query(),
                    ]
                );
            } else {
                session()->flash('warning', 'Could not geocode that search location. Showing results without distance sorting.');
                $listings = $listingsQuery
                    ->latest()
                    ->paginate(12)
                    ->withQueryString();
            }
        } else {
            // No distance filtering: standard query
            $listings = $listingsQuery
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        return view('listings.index', compact(
            'listings',
            'categories',
            'tags',
            'q',
            'categoryId',
            'tagId',
            'searchCity',
            'searchZip',
            'radiusKm'
        ));
    }

    // Calculate distance between two coordinates using Haversine formula
    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km
        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) ** 2 +
             cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) ** 2;

        $c = 2 * asin(sqrt($a));

        return $earthRadius * $c;
    }

    private function getRadiusFromRequest(): ?int
    {
        $radius = request('radius');
        $allowed = [5, 10, 25, 50];
        return in_array((int) $radius, $allowed, true) ? (int) $radius : null;
    }

    public function show(Listing $listing)
    {
        $listing->load(['category', 'user', 'tags']);
        return view('listings.show', compact('listing'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        return view('listings.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_eur' => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'image' => ['nullable', 'image', 'max:2048'],
            'location_city' => ['required', 'string', 'max:80'],
            'location_zip' => ['required', 'string', 'max:12'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('listings', 'public');
        }

        $priceCents = null;
        if ($data['price_eur'] !== null) {
            $priceCents = (int) round(((float) $data['price_eur']) * 100);
        }

        $coords = $this->geocoding->geocode($data['location_zip'], $data['location_city']);

        if (! $coords) {
            session()->flash('warning', 'Listing saved, but we could not place it on the map for that city/postcode.');
        }

        $listing = Listing::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'price_cents' => $priceCents,
            'image_path' => $imagePath,
            'is_sold' => false,
            'location_city' => $data['location_city'] ?? null,
            'location_zip' => $data['location_zip'] ?? null,
            'lat' => $coords['lat'] ?? null,
            'lng' => $coords['lng'] ?? null,
        ]);

        $listing->tags()->sync($data['tag_ids'] ?? []);

        return redirect()->route('listings.show', $listing)->with('status', 'Listing created.');
    }

    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->load('tags');
        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        return view('listings.edit', compact('listing', 'categories', 'tags'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_eur' => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'is_sold' => ['nullable', 'boolean'],
            'location_city' => ['required', 'string', 'max:80'],
            'location_zip' => ['required', 'string', 'max:12'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        if ($request->boolean('remove_image') && $listing->image_path) {
            Storage::disk('public')->delete($listing->image_path);
            $listing->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($listing->image_path) {
                Storage::disk('public')->delete($listing->image_path);
            }
            $listing->image_path = $request->file('image')->store('listings', 'public');
        }

        $priceCents = null;
        if ($data['price_eur'] !== null) {
            $priceCents = (int) round(((float) $data['price_eur']) * 100);
        }

        $coords = null;
        $locationChanged = $listing->location_city !== $data['location_city'] || $listing->location_zip !== $data['location_zip'];

        if ($locationChanged) {
            $coords = $this->geocoding->geocode($data['location_zip'], $data['location_city']);

            if (! $coords) {
                session()->flash('warning', 'Updated, but we could not map that new location.');
                $listing->lat = null;
                $listing->lng = null;
            }
        }

        $listing->fill([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'price_cents' => $priceCents,
            'is_sold' => $request->boolean('is_sold'),
            'location_city' => $data['location_city'] ?? null,
            'location_zip' => $data['location_zip'] ?? null,
        ])->save();

        if ($coords) {
            $listing->lat = $coords['lat'];
            $listing->lng = $coords['lng'];
            $listing->save();
        }

        $listing->tags()->sync($data['tag_ids'] ?? []);

        return redirect()->route('listings.show', $listing)->with('status', 'Listing updated.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        if ($listing->image_path) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $listing->delete();

        return redirect()->route('listings.index')->with('status', 'Listing deleted.');
    }

    public function toggleSold(Listing $listing)
    {
        abort_unless(auth()->id() === $listing->user_id || auth()->user()->is_admin, 403);

        $isSold = !$listing->is_sold;
        $listing->update([
            'is_sold' => $isSold,
            'is_reserved' => $isSold ? false : $listing->is_reserved
        ]);

        return back()->with('status', $listing->is_sold ? 'Marked as sold.' : 'Marked as active.');
    }

    public function toggleReserved(Listing $listing)
    {
        abort_unless(auth()->id() === $listing->user_id || auth()->user()->is_admin, 403);

        $isReserved = !$listing->is_reserved;
        $listing->update([
            'is_reserved' => $isReserved,
            'is_sold' => $isReserved ? false : $listing->is_sold
        ]);

        return back()->with('status', $listing->is_reserved ? 'Marked as reserved.' : 'Reservation removed.');
    }
}
