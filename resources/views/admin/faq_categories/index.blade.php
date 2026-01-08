<x-layouts.admin>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">FAQ Categories</h1>
        <a class="px-3 py-2 bg-black text-white rounded" href="{{ route('admin.faq-categories.create') }}">New</a>
    </div>

    <div class="bg-white rounded border">
        <table class="w-full">
            <thead>
            <tr class="text-left border-b">
                <th class="p-3">Name</th>
                <th class="p-3 w-48">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $cat)
                <tr class="border-b">
                    <td class="p-3">{{ $cat->name }}</td>
                    <td class="p-3 flex gap-2">
                        <a class="underline" href="{{ route('admin.faq-categories.edit', $cat) }}">Edit</a>
                        <x-confirm-modal 
                            title="Delete FAQ Category"
                            message="Are you sure you want to delete this FAQ category? This action cannot be undone."
                            confirm-text="Delete"
                            cancel-text="Cancel"
                        >
                            <x-slot name="trigger">
                                <button type="button" class="underline text-red-600">
                                    Delete
                                </button>
                            </x-slot>
                            <x-slot name="action">
                                <form method="POST" action="{{ route('admin.faq-categories.destroy', $cat) }}" class="inline">
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

    <div class="mt-4">{{ $categories->links() }}</div>
</x-layouts.admin>
