<x-layouts.admin>
    <h1 class="text-xl font-semibold mb-4">Edit FAQ item</h1>

    <form class="bg-white p-4 rounded border space-y-4" method="POST" action="{{ route('admin.faq-items.update', $item) }}">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Category</label>
            <select class="w-full border rounded p-2" name="faq_category_id" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('faq_category_id', $item->faq_category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Question</label>
            <input class="w-full border rounded p-2" name="question" value="{{ old('question', $item->question) }}" required>
        </div>

        <div>
            <label class="block font-medium">Answer</label>
            <textarea class="w-full border rounded p-2" name="answer" rows="5" required>{{ old('answer', $item->answer) }}</textarea>
        </div>

        <button class="px-3 py-2 bg-black text-white rounded">Save</button>
    </form>
</x-layouts.admin>
