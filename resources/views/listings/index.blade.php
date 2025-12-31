<x-layouts.public title="Listings">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Marketplace</h1>
            @auth
                <a href="{{ route('listings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Create Listing
                </a>
            @endauth
        </div>

        <x-flash-message />

        <!-- Search & Filters -->
        <form method="GET" class="bg-white shadow rounded p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="q" class="block text-sm font-medium mb-1">Search</label>
                    <input type="text" name="q" id="q" value="{{ $q }}" placeholder="Search..." class="w-full border-gray-300 rounded shadow-sm">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium mb-1">Category</label>
                    <select name="category" id="category" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tag" class="block text-sm font-medium mb-1">Tag</label>
                    <select name="tag" id="tag" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">All Tags</option>
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}" @selected($tagId == $t->id)>{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Filter</button>
                <a href="{{ route('listings.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Reset</a>
            </div>
        </form>

        @if($listings->isEmpty())
            <p class="text-gray-500 text-center py-8">No listings found.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing) }}" class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">
                        @if($listing->image_path)
                            <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                        @endif

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $listing->category->name }}</p>

                            @if($listing->price_cents)
                                <p class="font-semibold text-blue-600">€{{ number_format($listing->price_cents / 100, 2) }}</p>
                            @else
                                <p class="text-gray-500">Price on request</p>
                            @endif

                            @if($listing->is_sold)
                                <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded mt-2">SOLD</span>
                            @endif

                            @if($listing->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($listing->tags as $tag)
                                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</x-layouts.public>
