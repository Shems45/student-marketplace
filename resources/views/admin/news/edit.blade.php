<x-layouts.admin>
    <h1 class="text-xl font-semibold mb-4">Edit news item</h1>

    <form class="bg-white p-4 rounded border space-y-4" method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Title</label>
            <input class="w-full border rounded p-2" name="title" value="{{ old('title', $news->title) }}" required>
        </div>

        <div>
            <label class="block font-medium">Content</label>
            <textarea class="w-full border rounded p-2" name="content" rows="8" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Published at</label>
            <input class="w-full border rounded p-2" type="datetime-local" name="published_at"
                   value="{{ old('published_at', $news->published_at->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="space-y-2">
            <label class="block font-medium">Image</label>
            @if($news->image_path)
                <img class="max-w-sm rounded border" src="{{ asset('storage/'.$news->image_path) }}" alt="News image">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remove_image" value="1">
                    <span>Remove current image</span>
                </label>
            @endif
            <input type="file" name="image" accept="image/*">
        </div>

        <button class="px-3 py-2 bg-black text-white rounded">Save</button>
    </form>
</x-layouts.admin>
