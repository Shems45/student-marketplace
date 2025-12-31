<x-layouts.public title="Messages">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Messages</h1>

        <x-flash-message />

        <div class="bg-white shadow rounded overflow-hidden">
            @forelse($conversations as $c)
                @php
                    $other = $userId === $c->buyer_id ? $c->seller : $c->buyer;
                @endphp

                <a class="block p-6 border-b hover:bg-gray-50 transition" href="{{ route('conversations.show', $c) }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="font-semibold text-lg mb-1">{{ $other->username }}</div>
                            <div class="text-sm text-gray-600">
                                Listing: <span class="font-medium">{{ $c->listing->title }}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Last activity: {{ $c->updated_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p class="mb-2">No conversations yet.</p>
                    <a href="{{ route('listings.index') }}" class="text-blue-600 hover:underline">Browse listings</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.public>
