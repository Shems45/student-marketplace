<x-layouts.public title="Messages">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
                <p class="text-gray-600 mt-1">Inbox sorted by unread first</p>
            </div>
        </div>

        @if($conversations->isEmpty())
            <div class="bg-white border border-gray-100 rounded-xl p-10 text-center shadow-sm">
                <div class="flex justify-center mb-3">
                    <x-heroicon-o-chat-bubble-left-right class="w-16 h-16 text-gray-300" />
                </div>
                <p class="text-gray-700 font-semibold mb-2">No conversations yet</p>
                <p class="text-sm text-gray-500 mb-6">Start by messaging a seller on a listing.</p>
                <a href="{{ route('listings.index') }}" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800">
                    Browse listings
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($conversations as $c)
                    @php
                        $other = $userId === $c->buyer_id ? $c->seller : $c->buyer;
                        $preview = $c->last_message?->body ? \Illuminate\Support\Str::limit($c->last_message->body, 90) : 'No messages yet';
                    @endphp

                    <a href="{{ route('conversations.show', $c) }}" class="block">
                        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $other->username }}</h3>
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ $c->listing->title }}</span>
                                        @if(($c->unread_count ?? 0) > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">{{ $c->unread_count }} new</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✓ Read</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-700 flex items-center gap-2">
                                        <span class="text-gray-400">@</span>
                                        <span class="line-clamp-1">{{ $preview }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500">Last activity {{ $c->updated_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
