<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\NewsItem;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = NewsItem::query()->latest('published_at')->take(5)->get();

        $latestListings = Listing::query()
            ->with(['category', 'user', 'tags'])
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('latestNews', 'latestListings'));
    }
}
