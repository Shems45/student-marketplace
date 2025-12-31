<x-layouts.admin>
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Contact Messages</h1>
    </div>

    <x-flash-message />

    <form class="bg-white shadow rounded p-4 mb-6 flex gap-2" method="GET" action="{{ route('admin.contact-messages.index') }}">
        <input class="flex-1 border-gray-300 rounded shadow-sm" name="q" placeholder="Search name/email/subject..." value="{{ $q ?? '' }}">
        <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Search</button>
    </form>

    @if($messages->isEmpty())
        <p class="text-gray-500">No contact messages found.</p>
    @else
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr class="text-left">
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">From</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Subject</th>
                        <th class="px-6 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $m)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $m->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4">{{ $m->name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $m->email }}</td>
                            <td class="px-6 py-4">
                                <a class="text-blue-600 hover:underline" href="{{ route('admin.contact-messages.show', $m) }}">{{ $m->subject }}</a>
                            </td>
                            <td class="px-6 py-4 flex gap-4">
                                <a class="text-blue-600 hover:underline text-sm" href="{{ route('admin.contact-messages.show', $m) }}">Open</a>
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $m) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Delete this message?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
</x-layouts.admin>
