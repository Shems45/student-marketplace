<x-layouts.public title="Edit Listing">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Edit listing</h1>
            <p class="text-gray-600 mt-2">Update details and keep buyers informed</p>
        </div>

        <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data" class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="category_id" class="text-sm font-semibold text-gray-900">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $listing->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="price_eur" class="text-sm font-semibold text-gray-900">Price (EUR)</label>
                    <input type="number" name="price_eur" id="price_eur" value="{{ old('price_eur', $listing->price_cents ? $listing->price_cents / 100 : null) }}" step="0.01" min="0" max="99999" placeholder="Leave empty for 'on request'" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                    @error('price_eur')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-gray-900">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $listing->title) }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-gray-900">Description <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">{{ old('description', $listing->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($listing->image_path)
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-900">Current image</label>
                    <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="w-48 h-48 object-cover rounded-lg border border-gray-100">
                    <label class="flex items-center gap-2 text-sm text-red-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300">
                        <span>Remove current image</span>
                    </label>
                </div>
            @endif

            <div class="space-y-2">
                <label for="image" class="text-sm font-semibold text-gray-900">{{ $listing->image_path ? 'Replace image' : 'Image' }} (max 2MB)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="location_city" class="text-sm font-semibold text-gray-900">City <span class="text-red-500">*</span></label>
                    <input type="text" name="location_city" id="location_city" value="{{ old('location_city', $listing->location_city ?? '') }}" placeholder="e.g. Brussels" required maxlength="80" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                    @error('location_city')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="location_zip" class="text-sm font-semibold text-gray-900">Postcode <span class="text-red-500">*</span></label>
                    <input type="text" name="location_zip" id="location_zip" value="{{ old('location_zip', $listing->location_zip ?? '') }}" placeholder="e.g. 1000" required maxlength="12" inputmode="numeric" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                    @error('location_zip')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-900">Tags</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input
                                type="checkbox"
                                name="tag_ids[]"
                                value="{{ $tag->id }}"
                                @checked(in_array($tag->id, old('tag_ids', $listing->tags->pluck('id')->toArray())))
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                            >
                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tag_ids')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_sold" value="1" @checked(old('is_sold', $listing->is_sold)) class="rounded border-gray-300">
                    <span class="text-sm font-semibold text-gray-900">Mark as SOLD</span>
                </label>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">Update listing</button>
                <a href="{{ route('listings.show', $listing) }}" class="px-5 py-2.5 bg-white text-gray-800 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.public>
