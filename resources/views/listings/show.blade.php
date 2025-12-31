<x-layouts.public title="{{ $listing->title }}">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <x-flash-message />

        <div class="bg-white shadow rounded overflow-hidden">
            @if($listing->image_path)
                <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="w-full max-h-96 object-cover">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
            @endif

            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $listing->title }}</h1>
                        <p class="text-gray-600">{{ $listing->category->name }}</p>
                    </div>

                    @if($listing->price_cents)
                        <p class="text-2xl font-bold text-blue-600">€{{ number_format($listing->price_cents / 100, 2) }}</p>
                    @else
                        <p class="text-xl text-gray-500">Price on request</p>
                    @endif
                </div>

                @if($listing->is_sold)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                        This listing has been marked as SOLD.
                    </div>
                @endif

                @if($listing->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($listing->tags as $tag)
                            <span class="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="prose max-w-none mb-6">
                    <p class="whitespace-pre-line">{{ $listing->description }}</p>
                </div>

                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600">
                        Posted by <a href="{{ route('profiles.show', $listing->user) }}" class="text-blue-600 hover:underline">{{ $listing->user->username }}</a>
                        on {{ $listing->created_at->format('F j, Y') }}
                    </p>
                </div>

                @can('update', $listing)
                    <div class="border-t mt-6 pt-6 flex gap-3">
                        <a href="{{ route('listings.edit', $listing) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Edit Listing
                        </a>

                        <form method="POST" action="{{ route('listings.destroy', $listing) }}" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('listings.index') }}" class="text-blue-600 hover:underline">&larr; Back to Listings</a>
        </div>
    </div>
</x-layouts.public>
