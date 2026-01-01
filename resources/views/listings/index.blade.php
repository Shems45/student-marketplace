<x-layouts.public title="Listings">
    <div>
        <!-- Page Header -->
        <div class="mb-12 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-5xl font-bold text-gray-900">Marketplace</h1>
                <p class="text-lg text-gray-600 mt-2">Find what you need from other students</p>
            </div>
            <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gray-900 text-white text-sm font-semibold shadow-sm hover:bg-gray-800 transition">
                <span class="text-lg">＋</span>
                Create listing
            </a>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-100 rounded-xl p-6 mb-12 shadow-sm">
            <form method="GET" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="q" class="block text-sm font-semibold text-gray-900 mb-2">Search</label>
                        <input
                            type="text"
                            name="q"
                            id="q"
                            value="{{ $q }}"
                            placeholder="What are you looking for?"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm placeholder-gray-500 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        />
                    </div>

                    <!-- Category Select -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-900 mb-2">Category</label>
                        <select
                            name="category"
                            id="category"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        >
                            <option value="">All categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tag -->
                    <div>
                        <label for="tag" class="block text-sm font-semibold text-gray-900 mb-2">Tag</label>
                        <select
                            name="tag"
                            id="tag"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        >
                            <option value="">All tags</option>
                            @foreach($tags as $t)
                                <option value="{{ $t->id }}" @selected($tagId == $t->id)>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-900 mb-2">City</label>
                        <input
                            type="text"
                            name="city"
                            id="city"
                            list="belgian-cities"
                            value="{{ $searchCity }}"
                            placeholder="e.g. Brussels"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm placeholder-gray-500 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        />
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
                        <p class="mt-1 text-xs text-gray-500">Type to see Belgian city suggestions</p>
                    </div>

                    <!-- Postcode -->
                    <div>
                        <label for="postcode" class="block text-sm font-semibold text-gray-900 mb-2">Postcode</label>
                        <input
                            type="text"
                            name="postcode"
                            id="postcode"
                            value="{{ $searchZip }}"
                            placeholder="e.g. 1000"
                            inputmode="numeric"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm placeholder-gray-500 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        />
                    </div>

                    <!-- Radius -->
                    <div>
                        <label for="radius" class="block text-sm font-semibold text-gray-900 mb-2">Radius</label>
                        <select
                            name="radius"
                            id="radius"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition"
                        >
                            <option value="">Anywhere</option>
                            @foreach([5,10,25,50] as $r)
                                <option value="{{ $r }}" @selected($radiusKm === $r)>Within {{ $r }} km</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-2 flex-wrap">
                    <div class="text-xs text-gray-500">Belgium only • Use postcode + city for distance</div>
                    <div class="flex items-center gap-2">
                        @if($q || $categoryId || $tagId || $searchCity || $searchZip || $radiusKm)
                            <a href="{{ route('listings.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Clear filters</a>
                        @endif
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition shadow-sm"
                        >
                            <span class="text-lg">🔍</span>
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Listings Grid -->
        @if($listings->isEmpty())
            <div class="text-center py-20">
                <div class="text-5xl mb-4">📭</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No listings found</h2>
                <p class="text-gray-600 mb-6">Try adjusting your search or filters</p>
                <a href="{{ route('listings.index') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">View all listings</a>
            </div>
        @else
            <div>
                <p class="text-sm text-gray-600 mb-6">{{ $listings->total() }} {{ \Illuminate\Support\Str::plural('listing', $listings->total()) }} found</p>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 mb-12">
                    @foreach($listings as $listing)
                        <a href="{{ route('listings.show', $listing) }}" class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 hover:shadow-lg transition">
                            <!-- Image Container -->
                            <div class="relative bg-gray-100">
                                <div class="aspect-[4/3] overflow-hidden">
                                    @if($listing->image_path)
                                        <img
                                            src="{{ asset('storage/' . $listing->image_path) }}"
                                            alt="{{ $listing->title }}"
                                            class="h-full w-full object-cover group-hover:scale-105 transition duration-300"
                                        />
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-300 text-5xl">
                                            📦
                                        </div>
                                    @endif
                                </div>

                                <!-- Status Badge -->
                                @if($listing->is_sold)
                                    <div class="absolute top-3 right-3 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">SOLD</div>
                                @elseif($listing->is_reserved)
                                    <div class="absolute top-3 right-3 px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full">RESERVED</div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-5 space-y-3">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-gray-700 line-clamp-2">{{ $listing->title }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded">{{ $listing->category->name }}</span>
                                </div>

                                @if($listing->location_city || $listing->location_zip)
                                    <p class="text-sm text-gray-600 flex items-center gap-2">
                                        <span>📍</span>
                                        <span>{{ trim(($listing->location_zip ?? '') . ' ' . ($listing->location_city ?? '')) }}</span>
                                        @if(isset($listing->distance_km))
                                            <span class="text-xs text-gray-500">• {{ number_format($listing->distance_km, 1) }} km</span>
                                        @endif
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-sky-700">
                                        @if($listing->price_cents)
                                            €{{ number_format($listing->price_cents / 100, 2) }}
                                        @else
                                            <span class="text-sm text-gray-500">Request</span>
                                        @endif
                                    </span>

                                    @if($listing->tags->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($listing->tags->take(1) as $tag)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">{{ $tag->name }}</span>
                                            @endforeach
                                            @if($listing->tags->count() > 1)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">+{{ $listing->tags->count() - 1 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $listings->links() }}
                </div>
            </div>
        @endif
    </div>

    <script>
        (() => {
            // Simple city -> postcode autofill for Belgian cities
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

            const cityInput = document.getElementById('city');
            const zipInput = document.getElementById('postcode');
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
</x-layouts.public>
