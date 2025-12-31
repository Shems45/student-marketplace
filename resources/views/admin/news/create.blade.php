<x-layouts.admin>
    <h1 class="text-xl font-semibold mb-4">Create news item</h1>

    <form class="bg-white p-4 rounded border space-y-4" method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label class="block font-medium">Title</label>
            <input class="w-full border rounded p-2" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="block font-medium">Content</label>
            <textarea class="w-full border rounded p-2" name="content" rows="8" required>{{ old('content') }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Published at</label>
            <input class="w-full border rounded p-2" type="datetime-local" name="published_at" value="{{ old('published_at') }}" required>
        </div>

        <div>
            <label class="block font-medium">Image (optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button class="px-3 py-2 bg-black text-white rounded">Create</button>
    </form>
</x-layouts.admin>
