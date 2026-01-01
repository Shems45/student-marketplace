<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class FavoriteController extends Controller
{
    public function index()
    {
        $listings = auth()->user()
            ->favoriteListings()
            ->with(['category', 'user', 'tags'])
            ->latest('favorites.created_at')
            ->paginate(12);

        return view('favorites.index', compact('listings'));
    }

    public function store(Listing $listing)
    {
        auth()->user()->favoriteListings()->syncWithoutDetaching([$listing->id]);
        return back()->with('status', 'Added to favorites.');
    }

    public function destroy(Listing $listing)
    {
        auth()->user()->favoriteListings()->detach($listing->id);
        return back()->with('status', 'Removed from favorites.');
    }
}
