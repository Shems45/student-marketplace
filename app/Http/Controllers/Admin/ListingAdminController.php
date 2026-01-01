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
        $isSold = !$listing->is_sold;
        $listing->update([
            'is_sold' => $isSold,
            'is_reserved' => $isSold ? false : $listing->is_reserved,
        ]);

        return back()->with('status', 'Sold status updated.');
    }

    public function toggleReserved(Listing $listing)
    {
        $isReserved = !$listing->is_reserved;
        $listing->update([
            'is_reserved' => $isReserved,
            'is_sold' => $isReserved ? false : $listing->is_sold,
        ]);

        return back()->with('status', 'Reserved status updated.');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return back()->with('status', 'Listing deleted.');
    }
}
