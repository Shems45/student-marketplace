<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');
        $tagId = $request->query('tag');

        $listings = Listing::query()
            ->with(['category', 'user', 'tags'])
            ->when($q, fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            }))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($tagId, fn ($query) => $query->whereHas('tags', fn ($t) => $t->where('tags.id', $tagId)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        return view('listings.index', compact('listings', 'categories', 'tags', 'q', 'categoryId', 'tagId'));
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

        $listing = Listing::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'price_cents' => $priceCents,
            'image_path' => $imagePath,
            'is_sold' => false,
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

        $listing->fill([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'price_cents' => $priceCents,
            'is_sold' => $request->boolean('is_sold'),
        ])->save();

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
}
