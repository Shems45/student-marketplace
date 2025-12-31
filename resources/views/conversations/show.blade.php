<x-layouts.public title="Conversation">
    @php
        $userId = auth()->id();
        $other = $userId === $conversation->buyer_id ? $conversation->seller : $conversation->buyer;
    @endphp

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="text-2xl font-bold">{{ $other->username }}</div>
                <div class="text-sm text-gray-600 mt-1">
                    Listing: <a class="text-blue-600 hover:underline" href="{{ route('listings.show', $conversation->listing) }}">{{ $conversation->listing->title }}</a>
                </div>
            </div>

            <a class="text-blue-600 hover:underline" href="{{ route('conversations.index') }}">← Back to Messages</a>
        </div>

        <x-flash-message />

        <div class="bg-white shadow rounded p-6 mb-4" style="height: 480px; overflow-y: auto;">
            <div class="space-y-4">
                @forelse($conversation->messages as $m)
                    @php $mine = $m->sender_id === $userId; @endphp

                    <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%]">
                            <div class="{{ $mine ? 'bg-blue-500 text-white' : 'bg-gray-100 text-black' }} rounded-lg px-4 py-3 shadow">
                                <div class="text-xs {{ $mine ? 'text-blue-100' : 'text-gray-500' }} mb-1">
                                    {{ $mine ? 'You' : $m->sender->username }} • {{ $m->created_at->format('H:i') }}
                                </div>
                                <div class="whitespace-pre-line">{{ $m->body }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        No messages yet. Start the conversation!
                    </div>
                @endforelse
            </div>
        </div>

        <form class="flex gap-3" method="POST" action="{{ route('messages.store', $conversation) }}">
            @csrf
            <input class="flex-1 border-gray-300 rounded-lg shadow-sm px-4 py-3" 
                   name="body" 
                   placeholder="Type a message..." 
                   required 
                   maxlength="2000"
                   autocomplete="off">
            <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Send</button>
        </form>
    </div>
</x-layouts.public>
