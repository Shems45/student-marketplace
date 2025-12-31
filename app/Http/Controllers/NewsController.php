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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
