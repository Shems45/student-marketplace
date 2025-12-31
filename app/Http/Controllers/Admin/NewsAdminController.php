<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsAdminController extends Controller
{
    public function index()
    {
        $news = NewsItem::query()->latest('published_at')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        NewsItem::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'content' => $data['content'],
            'published_at' => $data['published_at'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.news.index')->with('status', 'News item created.');
    }

    public function edit(NewsItem $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, NewsItem $news)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_image') && $news->image_path) {
            Storage::disk('public')->delete($news->image_path);
            $news->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->fill([
            'title' => $data['title'],
            'content' => $data['content'],
            'published_at' => $data['published_at'],
        ])->save();

        return redirect()->route('admin.news.index')->with('status', 'News item updated.');
    }

    public function destroy(NewsItem $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('status', 'News item deleted.');
    }
}
