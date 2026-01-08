<x-layouts.admin>
    <a class="text-blue-600 hover:underline mb-4 inline-block" href="{{ route('admin.contact-messages.index') }}">← Back to Messages</a>

    <div class="bg-white shadow rounded p-6 space-y-4 mt-4">
        <div class="grid grid-cols-2 gap-4 pb-4 border-b">
            <div>
                <strong class="text-gray-700">Date</strong>
                <p>{{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div>
                <strong class="text-gray-700">From</strong>
                <p>{{ $contactMessage->name }}</p>
            </div>
            <div>
                <strong class="text-gray-700">Email</strong>
                <p class="text-blue-600"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
            </div>
            <div>
                <strong class="text-gray-700">Subject</strong>
                <p>{{ $contactMessage->subject }}</p>
            </div>
            <div>
                <strong class="text-gray-700">Status</strong>
                @if($contactMessage->replied_at)
                    <span class="inline-block px-2 py-1 text-xs border border-green-500 text-green-700 rounded-full">✓ Answered</span>
                @else
                    <span class="inline-block px-2 py-1 text-xs border border-gray-400 text-gray-600 rounded-full">Unanswered</span>
                @endif
            </div>
        </div>

        <div>
            <strong class="text-gray-700 block mb-2">Message</strong>
            <div class="bg-gray-50 p-4 rounded whitespace-pre-line text-gray-800">{{ $contactMessage->message }}</div>
        </div>

        @if($contactMessage->replied_at)
            <div class="bg-green-50 p-4 rounded border border-green-200">
                <strong class="text-gray-700 block mb-2">Admin Reply (sent {{ $contactMessage->replied_at->format('Y-m-d H:i') }})</strong>
                <div class="whitespace-pre-line text-gray-800">{{ $contactMessage->admin_reply }}</div>
            </div>
        @endif

        <!-- Reply Form -->
        <div class="pt-4 border-t space-y-4">
            <form method="POST" action="{{ route('admin.contact-messages.reply', $contactMessage) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="admin_reply" class="block text-sm font-medium text-gray-700 mb-1">{{ $contactMessage->replied_at ? 'Update Reply' : 'Reply to User' }}</label>
                    <textarea
                        name="admin_reply"
                        id="admin_reply"
                        rows="6"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        placeholder="Type your reply here..."
                    >{{ old('admin_reply', $contactMessage->admin_reply) }}</textarea>
                    @error('admin_reply')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">
                        Send Reply via Email
                    </button>
                </div>
            </form>

            <x-confirm-modal 
                title="Delete Message"
                message="Are you sure you want to delete this contact message? This action cannot be undone."
                confirm-text="Delete"
                cancel-text="Cancel"
            >
                <x-slot name="trigger">
                    <button type="button" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </x-slot>
                <x-slot name="action">
                    <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                            Delete
                        </button>
                    </form>
                </x-slot>
            </x-confirm-modal>
        </div>
    </div>
</x-layouts.admin>
