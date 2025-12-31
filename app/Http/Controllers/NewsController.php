<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class NewsController extends Controller
{
    public function index()
    {
        $news = NewsItem::query()->latest('published_at')->paginate(10);
        return view('news.index', compact('news'));
    }

    public function show(NewsItem $news)
    {
        return view('news.show', compact('news'));
    }
}
