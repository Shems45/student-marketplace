<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;

class ListingAdminController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.listings.index', compact('listings'));
    }

    public function toggleFeatured(Listing $listing)
    {
        $listing->update([
            'is_featured' => !$listing->is_featured,
        ]);

        return back()->with('status', 'Featured status updated.');
    }

    public function toggleSold(Listing $listing)
    {
        $listing->update([
            'is_sold' => !$listing->is_sold,
        ]);

        return back()->with('status', 'Sold status updated.');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return back()->with('status', 'Listing deleted.');
    }
}
