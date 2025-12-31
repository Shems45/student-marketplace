<x-layouts.public>
    <a class="underline" href="{{ route('news.index') }}">Back</a>

    <h1 class="text-2xl font-semibold mt-3">{{ $news->title }}</h1>
    <div class="text-sm text-gray-600 mb-4">{{ $news->published_at->format('Y-m-d H:i') }}</div>

    @if($news->image_path)
        <img class="max-w-2xl rounded border mb-4" src="{{ asset('storage/'.$news->image_path) }}" alt="News image">
    @endif

    <div class="prose max-w-none">
        {{ $news->content }}
    </div>
</x-layouts.public>
