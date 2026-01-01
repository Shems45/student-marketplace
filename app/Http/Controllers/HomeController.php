<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\NewsItem;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = NewsItem::query()->latest('published_at')->take(5)->get();

        $featuredListings = Listing::query()
            ->where('is_featured', true)
            ->where('is_sold', false)
            ->with(['category', 'user', 'tags'])
            ->latest()
            ->take(8)
            ->get();

        $latestListings = Listing::query()
            ->where('is_sold', false)
            ->with(['category', 'user', 'tags'])
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('latestNews', 'featuredListings', 'latestListings'));
    }
}
