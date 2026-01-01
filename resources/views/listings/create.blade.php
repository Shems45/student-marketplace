<x-layouts.public title="Create Listing">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Create a listing</h1>
            <p class="text-gray-600 mt-2">Share your item with other students</p>
        </div>

        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="category_id" class="text-sm font-semibold text-gray-900">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="price_eur" class="text-sm font-semibold text-gray-900">Price (EUR)</label>
                    <input type="number" name="price_eur" id="price_eur" value="{{ old('price_eur') }}" step="0.01" min="0" max="99999" placeholder="Leave empty for 'on request'" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                    @error('price_eur')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-gray-900">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-gray-900">Description <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="image" class="text-sm font-semibold text-gray-900">Image (max 2MB)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="location_city" class="text-sm font-semibold text-gray-900">City <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="location_city"
                        id="location_city"
                        list="belgian-cities"
                        value="{{ old('location_city') }}"
                        placeholder="e.g. Brussels"
                        required
                        maxlength="80"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                    >
                    <datalist id="belgian-cities">
                        <option value="Brussels" />
                        <option value="Antwerp" />
                        <option value="Ghent" />
                        <option value="Leuven" />
                        <option value="Bruges" />
                        <option value="Mechelen" />
                        <option value="Liege" />
                        <option value="Namur" />
                        <option value="Charleroi" />
                        <option value="Hasselt" />
                        <option value="Kortrijk" />
                        <option value="Mons" />
                        <option value="Aalst" />
                        <option value="Ostend" />
                        <option value="Genk" />
                        <option value="Sint-Niklaas" />
                        <option value="Roeselare" />
                        <option value="Tournai" />
                    </datalist>
                    <p class="text-xs text-gray-500">Type to see Belgian city suggestions; postcode auto-fills for known cities.</p>
                    @error('location_city')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="location_zip" class="text-sm font-semibold text-gray-900">Postcode <span class="text-red-500">*</span></label>
                    <input type="text" name="location_zip" id="location_zip" value="{{ old('location_zip') }}" placeholder="e.g. 1000" required maxlength="12" inputmode="numeric" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
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
                                @checked(in_array($tag->id, old('tag_ids', [])))
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

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">Create listing</button>
                <a href="{{ route('listings.index') }}" class="px-5 py-2.5 bg-white text-gray-800 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.public>

        <script>
            (() => {
                // City -> postcode mapping for Belgian cities
                const cityZipMap = {
                    Brussels: '1000',
                    Antwerp: '2000',
                    Ghent: '9000',
                    Leuven: '3000',
                    Bruges: '8000',
                    Mechelen: '2800',
                    Liege: '4000',
                    Namur: '5000',
                    Charleroi: '6000',
                    Hasselt: '3500',
                    Kortrijk: '8500',
                    Mons: '7000',
                    Aalst: '9300',
                    Ostend: '8400',
                    Genk: '3600',
                    'Sint-Niklaas': '9100',
                    Roeselare: '8800',
                    Tournai: '7500',
                };

                const cityInput = document.getElementById('location_city');
                const zipInput = document.getElementById('location_zip');
                if (!cityInput || !zipInput) return;

                const fillZip = () => {
                    const key = (cityInput.value || '').trim().toLowerCase();
                    const match = Object.keys(cityZipMap).find(c => c.toLowerCase() === key);
                    if (match) {
                        zipInput.value = cityZipMap[match];
                    }
                };

                cityInput.addEventListener('change', fillZip);
                cityInput.addEventListener('blur', fillZip);
            })();
        </script>
