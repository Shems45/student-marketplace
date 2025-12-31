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
                        <form method="POST" action="{{ route('admin.faq-categories.destroy', $cat) }}">
                            @csrf
                            @method('DELETE')
                            <button class="underline text-red-600" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
</x-layouts.admin>
