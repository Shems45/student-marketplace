<x-layouts.public :title="$listing->title">
    <div>
        <!-- Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('listings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to listings</a>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Image & Details -->
            <div class="lg:col-span-2">
                <!-- Image -->
                <div class="mb-8 bg-gray-100 rounded-xl overflow-hidden">
                    @if($listing->image_path)
                        <img
                            src="{{ asset('storage/' . $listing->image_path) }}"
                            alt="{{ $listing->title }}"
                            class="w-full h-64 md:h-80 object-cover"
                        />
                    @else
                        <div class="w-full h-64 md:h-80 flex items-center justify-center text-gray-400 text-6xl">
                            📦
                        </div>
                    @endif
                </div>

                <!-- Title & Basic Info -->
                <div class="mb-8">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full">{{ $listing->category->name }}</span>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $listing->title }}</h1>
                    <p class="text-gray-600">Posted by <a href="{{ route('profiles.show', $listing->user) }}" class="font-semibold text-gray-900 hover:underline">{{ $listing->user->username }}</a> • {{ $listing->created_at->diffForHumans() }}</p>

                    @if($listing->location_city || $listing->location_zip)
                        <p class="text-sm text-gray-600 mt-1">
                            📍 {{ trim(($listing->location_zip ?? '') . ' ' . ($listing->location_city ?? '')) }}
                        </p>
                    @endif
                </div>

                <!-- Status Alert -->
                @if($listing->is_sold)
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm font-semibold text-red-800">✕ This item has been sold</p>
                    </div>
                @endif

                <!-- Tags -->
                @if($listing->tags->isNotEmpty())
                    <div class="mb-8 flex flex-wrap gap-2">
                        @foreach($listing->tags as $tag)
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- Description -->
                <div class="prose prose-sm max-w-none mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-600 whitespace-pre-line leading-relaxed">{{ $listing->description }}</p>
                </div>

                <!-- Owner Actions -->
                @can('update', $listing)
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Manage Listing</h3>
                        <div class="flex gap-3 flex-wrap">
                            <a
                                href="{{ route('listings.edit', $listing) }}"
                                class="px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition"
                            >
                                Edit
                            </a>

                            <form method="POST" action="{{ route('listings.toggleSold', $listing) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition"
                                >
                                    {{ $listing->is_sold ? 'Mark as active' : 'Mark as sold' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('listings.destroy', $listing) }}" onsubmit="return confirm('Delete this listing permanently?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan

                <!-- Admin Actions -->
                @if(auth()->check() && auth()->user()->is_admin)
                    <div class="border border-gray-200 bg-white rounded-xl p-5 mt-12 shadow-sm max-w-2xl space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">⚙️</span>
                            <h3 class="text-lg font-semibold text-gray-900">Admin Controls</h3>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 text-sm">
                            <span class="px-2.5 py-1 rounded-full border {{ $listing->is_featured ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                {{ $listing->is_featured ? 'Featured: yes' : 'Featured: no' }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full border {{ $listing->is_sold ? 'bg-red-50 text-red-700 border-red-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}">
                                {{ $listing->is_sold ? 'Sold' : 'Active' }}
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.listings.toggleFeatured', $listing) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="px-5 py-3 text-sm font-semibold rounded-lg border {{ $listing->is_featured ? 'bg-gray-900 text-white border-gray-900 hover:bg-gray-800' : 'bg-amber-500 text-white border-amber-600 hover:bg-amber-600' }} transition"
                                >
                                    {{ $listing->is_featured ? '⭐ Remove featured' : '⭐ Mark as featured' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.listings.index') }}" class="px-5 py-3 text-sm font-semibold rounded-lg border bg-white text-gray-800 hover:bg-gray-50">
                                Admin listings
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Sidebar -->
            <div class="lg:col-span-1">
                <!-- Price Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6 sticky top-20 shadow-sm">
                    <div class="mb-6">
                        @if($listing->price_cents)
                            <p class="text-4xl font-bold text-sky-700">€{{ number_format($listing->price_cents / 100, 2) }}</p>
                            <p class="text-sm text-gray-600 mt-1">Listed price</p>
                        @else
                            <p class="text-2xl font-semibold text-gray-900">Price on request</p>
                            <p class="text-sm text-gray-600 mt-1">Contact seller for details</p>
                        @endif
                    </div>

                    @if($listing->location_city || $listing->location_zip)
                        <div class="mb-6 flex items-start gap-2 text-sm text-gray-700">
                            <span class="mt-[2px]">📍</span>
                            <div>
                                <p class="font-semibold">{{ trim(($listing->location_zip ?? '') . ' ' . ($listing->location_city ?? '')) }}</p>
                                <p class="text-gray-500">Belgium</p>
                            </div>
                        </div>
                    @endif

                    <!-- Message/Login Action -->
                    @auth
                        @if(auth()->id() !== $listing->user_id)
                            <form method="POST" action="{{ route('conversations.start', $listing) }}" class="mb-3">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full px-6 py-3 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition shadow-sm"
                                >
                                    Message Seller
                                </button>
                            </form>

                            <!-- Favorite Button -->
                            @php $isFav = auth()->user()->favoriteListings()->where('listing_id', $listing->id)->exists(); @endphp
                            @if(!$isFav)
                                <form method="POST" action="{{ route('favorites.store', $listing) }}">
                                    @csrf
                                    <button type="submit" class="w-full px-6 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                        ❤️ Save to favorites
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('favorites.destroy', $listing) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-6 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                        💔 Remove from favorites
                                    </button>
                                </form>
                            @endif
                        @endif
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="block w-full px-6 py-3 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition text-center shadow-sm"
                        >
                            Sign in to Message
                        </a>
                    @endauth

                    <!-- Info List -->
                    <div class="border-t border-gray-100 pt-6 space-y-4">
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">Condition</p>
                            <p class="text-sm text-gray-900 font-medium mt-1">Used</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">Posted</p>
                            <p class="text-sm text-gray-900 font-medium mt-1">{{ $listing->created_at->diffForHumans() }}</p>
                        </div>
                        @if($listing->is_sold)
                            <div>
                                <p class="text-xs text-gray-600 font-semibold uppercase">Status</p>
                                <p class="text-sm text-red-600 font-semibold mt-1">Sold</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seller Info Card -->
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Seller</h3>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-lg">👤</div>
                        <div class="flex-1">
                            <a href="{{ route('profiles.show', $listing->user) }}" class="font-semibold text-gray-900 hover:underline">{{ $listing->user->username }}</a>
                            <p class="text-sm text-gray-600 mt-1">{{ $listing->user->bio ?: 'No bio' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
