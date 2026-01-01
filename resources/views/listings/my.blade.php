<x-layouts.public title="My Listings">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Listings</h1>

        @if($listings->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600 mb-4">You haven't created any listings yet.</p>
                <a href="{{ route('listings.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Create Your First Listing
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($listings as $l)
                    <div class="bg-white border rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold mb-2">{{ $l->title }}</h3>
                                <p class="text-gray-600 mb-3">{{ Str::limit($l->description, 150) }}</p>

                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="font-semibold text-blue-600">€{{ number_format($l->price, 2) }}</span>
                                    <span>{{ $l->category->name }}</span>
                                    <span>Posted {{ $l->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            @if($l->image_path)
                                <img src="{{ asset('storage/' . $l->image_path) }}"
                                     alt="{{ $l->title }}"
                                     class="w-24 h-24 object-cover rounded-lg border border-gray-100 ml-4">
                            @endif
                        </div>

                        <div class="flex gap-4 mt-4 pt-4 border-t">
                            <a href="{{ route('listings.show', $l) }}"
                               class="text-blue-600 hover:underline font-medium">
                                View
                            </a>

                            <a href="{{ route('listings.edit', $l) }}"
                               class="text-blue-600 hover:underline font-medium">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('listings.destroy', $l) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline font-medium"
                                        onclick="return confirm('Are you sure you want to delete this listing?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
