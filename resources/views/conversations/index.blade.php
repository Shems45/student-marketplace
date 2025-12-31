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
                            <div class="flex items-center gap-3 mb-1">
                                <div class="font-semibold text-lg">{{ $other->username }}</div>
                                @if(($c->unread_count ?? 0) > 0)
                                    <span class="px-2 py-1 text-xs bg-red-500 text-white rounded-full font-semibold">{{ $c->unread_count }}</span>
                                @elseif(($c->last_direction ?? null) === 'sent')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Sent</span>
                                @elseif(($c->last_direction ?? null) === 'received')
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">Read</span>
                                @endif
                            </div>
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
