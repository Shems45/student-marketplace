<x-layouts.admin>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">News</h1>
        <a class="px-3 py-2 bg-black text-white rounded" href="{{ route('admin.news.create') }}">New</a>
    </div>

    <div class="bg-white rounded border">
        <table class="w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3">Title</th>
                    <th class="p-3">Published</th>
                    <th class="p-3 w-48">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($news as $item)
                <tr class="border-b">
                    <td class="p-3">{{ $item->title }}</td>
                    <td class="p-3">{{ $item->published_at->format('Y-m-d H:i') }}</td>
                    <td class="p-3 flex gap-2">
                        <a class="underline" href="{{ route('news.show', $item) }}" target="_blank">View</a>
                        <a class="underline" href="{{ route('admin.news.edit', $item) }}">Edit</a>
                        <x-confirm-modal 
                            title="Delete News Item"
                            message="Are you sure you want to delete this news item? This action cannot be undone."
                            confirm-text="Delete"
                            cancel-text="Cancel"
                        >
                            <x-slot name="trigger">
                                <button type="button" class="underline text-red-600">
                                    Delete
                                </button>
                            </x-slot>
                            <x-slot name="action">
                                <form method="POST" action="{{ route('admin.news.destroy', $item) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                                        Delete
                                    </button>
                                </form>
                            </x-slot>
                        </x-confirm-modal>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $news->links() }}
    </div>
</x-layouts.admin>
