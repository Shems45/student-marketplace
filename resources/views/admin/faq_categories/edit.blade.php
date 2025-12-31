<x-layouts.admin>
    <h1 class="text-xl font-semibold mb-4">Edit FAQ category</h1>

    <form class="bg-white p-4 rounded border space-y-4" method="POST" action="{{ route('admin.faq-categories.update', $category) }}">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium">Name</label>
            <input class="w-full border rounded p-2" name="name" value="{{ old('name', $category->name) }}" required>
        </div>
        <button class="px-3 py-2 bg-black text-white rounded">Save</button>
    </form>
</x-layouts.admin>
