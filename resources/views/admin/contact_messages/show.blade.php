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
        </div>

        <div>
            <strong class="text-gray-700 block mb-2">Message</strong>
            <div class="bg-gray-50 p-4 rounded whitespace-pre-line text-gray-800">{{ $contactMessage->message }}</div>
        </div>

        <div class="pt-4 flex gap-4 border-t">
            <a class="text-blue-600 hover:underline text-sm" href="mailto:{{ $contactMessage->email }}?subject={{ urlencode('Re: ' . $contactMessage->subject) }}">
                Reply via email
            </a>

            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Delete this message?')">Delete</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
