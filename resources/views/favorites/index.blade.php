<x-layouts.public title="Favorites">
    <div>
        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-5xl font-bold text-gray-900">My Favorites</h1>
            <p class="text-lg text-gray-600 mt-2">Listings you've saved for later</p>
        </div>

        <!-- Listings Grid -->
        @if($listings->isEmpty())
            <div class="text-center py-20">
                <div class="flex justify-center mb-4">
                    <x-heroicon-o-heart class="w-16 h-16 text-gray-300" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No favorites yet</h2>
                <p class="text-gray-600 mb-6">Start adding listings to your favorites</p>
                <a href="{{ route('listings.index') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">Browse listings</a>
            </div>
        @else
            <div>
                <p class="text-sm text-gray-600 mb-6">{{ $listings->total() }} {{ \Illuminate\Support\Str::plural('favorite', $listings->total()) }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 mb-12">
                    @foreach($listings as $listing)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 hover:shadow-lg transition">
                            <a href="{{ route('listings.show', $listing) }}" class="group block">
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
                                    </div>
                                </div>
                            </a>

                            <!-- Remove from favorites -->
                            <div class="px-5 pb-4">
                                <form method="POST" action="{{ route('favorites.destroy', $listing) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                                        💔 Remove from favorites
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $listings->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>
