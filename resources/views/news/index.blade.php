<x-layouts.public>
    <h1 class="text-xl font-semibold mb-4">News</h1>

    <div class="space-y-3">
        @foreach($news as $item)
            <a class="block bg-white border rounded p-4 hover:bg-gray-50" href="{{ route('news.show', $item) }}">
                <div class="font-semibold">{{ $item->title }}</div>
                <div class="text-sm text-gray-600">{{ $item->published_at->format('Y-m-d H:i') }}</div>
            </a>
        @endforeach
    </div>

    <div class="mt-4">{{ $news->links() }}</div>
</x-layouts.public>
