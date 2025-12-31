<x-layouts.public>
    <h1 class="text-2xl font-semibold mb-6">Student Marketplace</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <section class="bg-white border rounded p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Latest news</h2>
                <a class="underline" href="{{ route('news.index') }}">All</a>
            </div>

            <div class="space-y-2">
                @foreach($latestNews as $item)
                    <a class="block hover:bg-gray-50 rounded p-2" href="{{ route('news.show', $item) }}">
                        <div class="font-medium">{{ $item->title }}</div>
                        <div class="text-sm text-gray-600">{{ $item->published_at->format('Y-m-d H:i') }}</div>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="bg-white border rounded p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Latest listings</h2>
                <a class="underline" href="{{ route('listings.index') }}">All</a>
            </div>

            <div class="space-y-3">
                @foreach($latestListings as $listing)
                    <a class="block border rounded p-3 hover:bg-gray-50" href="{{ route('listings.show', $listing) }}">
                        <div class="font-medium">{{ $listing->title }}</div>
                        <div class="text-sm text-gray-600">
                            {{ $listing->category->name ?? 'Uncategorized' }} - by {{ $listing->user->username }}
                        </div>
                        <div class="text-sm mt-1">
                            @if(!is_null($listing->price_cents))
                                €{{ number_format($listing->price_cents / 100, 2) }}
                            @else
                                Price on request
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.public>
