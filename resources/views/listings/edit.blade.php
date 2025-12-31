<x-layouts.public title="Edit Listing">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Edit Listing</h1>

        <x-flash-message />

        <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data" class="bg-white shadow rounded p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" required class="w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $listing->category_id) == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $listing->title) }}" required class="w-full border-gray-300 rounded shadow-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="w-full border-gray-300 rounded shadow-sm">{{ old('description', $listing->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price_eur" class="block text-sm font-medium mb-1">Price (EUR)</label>
                <input type="number" name="price_eur" id="price_eur" value="{{ old('price_eur', $listing->price_cents ? $listing->price_cents / 100 : null) }}" step="0.01" min="0" max="99999" placeholder="Leave empty for 'Price on request'" class="w-full border-gray-300 rounded shadow-sm">
                @error('price_eur')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($listing->image_path)
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Current Image</label>
                    <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="w-48 h-48 object-cover rounded mb-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300">
                        <span class="text-sm text-red-600">Remove current image</span>
                    </label>
                </div>
            @endif

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-1">{{ $listing->image_path ? 'Replace Image' : 'Image' }} (max 2MB)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded shadow-sm">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tag_ids" class="block text-sm font-medium mb-1">Tags (Hold Ctrl to select multiple)</label>
                <select name="tag_ids[]" id="tag_ids" multiple size="6" class="w-full border-gray-300 rounded shadow-sm">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', $listing->tags->pluck('id')->toArray())))>{{ $tag->name }}</option>
                    @endforeach
                </select>
                @error('tag_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_sold" value="1" @checked(old('is_sold', $listing->is_sold)) class="rounded border-gray-300">
                    <span class="text-sm font-medium">Mark as SOLD</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update Listing
                </button>
                <a href="{{ route('listings.show', $listing) }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.public>
