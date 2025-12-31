<x-layouts.public>
    <h1 class="text-xl font-semibold mb-4">FAQ</h1>

    @forelse($categories as $cat)
        <div class="bg-white border rounded p-4 mb-4">
            <h2 class="font-semibold mb-3">{{ $cat->name }}</h2>

            <div class="space-y-3">
                @foreach($cat->items as $item)
                    <div class="border rounded p-3">
                        <div class="font-medium">{{ $item->question }}</div>
                        <div class="text-gray-700 mt-1">{{ $item->answer }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-gray-600">No FAQ items yet.</div>
    @endforelse
</x-layouts.public>
