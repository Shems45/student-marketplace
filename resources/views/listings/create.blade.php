<x-layouts.public title="Create Listing">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Create New Listing</h1>

        <x-flash-message />

        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded p-6">
            @csrf

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" required class="w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border-gray-300 rounded shadow-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="w-full border-gray-300 rounded shadow-sm">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price_eur" class="block text-sm font-medium mb-1">Price (EUR)</label>
                <input type="number" name="price_eur" id="price_eur" value="{{ old('price_eur') }}" step="0.01" min="0" max="99999" placeholder="Leave empty for 'Price on request'" class="w-full border-gray-300 rounded shadow-sm">
                @error('price_eur')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-1">Image (max 2MB)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded shadow-sm">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tag_ids" class="block text-sm font-medium mb-1">Tags (Hold Ctrl to select multiple)</label>
                <select name="tag_ids[]" id="tag_ids" multiple size="6" class="w-full border-gray-300 rounded shadow-sm">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', [])))>{{ $tag->name }}</option>
                    @endforeach
                </select>
                @error('tag_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Create Listing
                </button>
                <a href="{{ route('listings.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.public>
