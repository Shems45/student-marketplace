@php
    $userId = auth()->id();
    $other = $userId === $conversation->buyer_id ? $conversation->seller : $conversation->buyer;
@endphp

<x-layouts.public :title="'Chat with ' . $other->username">

    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('conversations.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-block">← Back to messages</a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $other->username }}</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Discussing <a href="{{ route('listings.show', $conversation->listing) }}" class="font-semibold text-gray-900 hover:underline">{{ $conversation->listing->title }}</a>
                </p>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm flex flex-col h-[600px]">
            <!-- Messages Area -->
            <div id="chat" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gradient-to-b from-gray-50 to-white">
                @forelse($conversation->messages as $m)
                    @php $mine = $m->sender_id === $userId; @endphp

                    <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] md:max-w-[60%]">
                            <!-- Sender name (show for received messages) -->
                            @if(!$mine)
                                <p class="text-xs text-gray-600 font-medium mb-1">{{ $m->sender->username }}</p>
                            @endif

                            <!-- Message Bubble -->
                            <div class="{{ $mine ? 'bg-gray-900 text-white rounded-3xl rounded-br-none' : 'bg-gray-100 text-gray-900 rounded-3xl rounded-bl-none' }} px-5 py-3 shadow-sm">
                                <p class="text-sm break-words">{{ $m->body }}</p>
                            </div>

                            <!-- Time -->
                            <p class="text-xs text-gray-500 mt-1 {{ $mine ? 'text-right' : 'text-left' }}">
                                {{ $m->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <div class="flex justify-center mb-3">
                                <x-heroicon-o-chat-bubble-left-right class="w-20 h-20 text-gray-300" />
                            </div>
                            <p class="text-gray-600">No messages yet. Start the conversation!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-100"></div>

            <!-- Input Area -->
            <form
                class="p-4 flex gap-3 bg-white sticky bottom-0"
                method="POST"
                action="{{ route('messages.store', $conversation) }}"
            >
                @csrf
                <input
                    type="text"
                    name="body"
                    placeholder="Type a message..."
                    required
                    maxlength="2000"
                    autocomplete="off"
                    class="flex-1 px-5 py-3 rounded-full border border-gray-200 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900 placeholder-gray-500"
                />
                <button
                    type="submit"
                    class="px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-full hover:bg-gray-800 transition"
                >
                    Send
                </button>
            </form>
        </div>
    </div>

    <script>
        // Auto scroll to bottom
        const chatEl = document.getElementById('chat');
        if (chatEl) {
            chatEl.scrollTop = chatEl.scrollHeight;

            // Keep scrolling on new messages
            const observer = new MutationObserver(() => {
                chatEl.scrollTop = chatEl.scrollHeight;
            });
            observer.observe(chatEl, { childList: true });
        }
    </script>
</x-layouts.public>
