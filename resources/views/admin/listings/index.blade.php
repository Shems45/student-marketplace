<x-layouts.admin>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manage Listings</h1>
        <a href="{{ route('listings.index') }}" class="text-sm text-sky-700 hover:text-sky-800">View public listings →</a>
    </div>

    @if(session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Seller</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Location</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Price</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Featured</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listings as $listing)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <a href="{{ route('listings.show', $listing) }}" class="font-medium text-gray-900 hover:text-sky-700 hover:underline" target="_blank">
                                {{ \Illuminate\Support\Str::limit($listing->title, 40) }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            <a href="{{ route('profiles.show', $listing->user) }}" class="hover:text-sky-700" target="_blank">
                                {{ $listing->user->username ?? '—' }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $listing->category->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            @if($listing->location_city || $listing->location_zip)
                                <span class="text-xs">📍 {{ $listing->location_zip }} {{ $listing->location_city }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-900">
                            @if(!is_null($listing->price_cents))
                                €{{ number_format($listing->price_cents / 100, 2) }}
                            @else
                                <span class="text-xs text-gray-500">On request</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('admin.listings.toggleFeatured', $listing) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $listing->is_featured ? 'bg-amber-50 text-amber-700 border-amber-300 hover:bg-amber-100' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                                >
                                    {{ $listing->is_featured ? '⭐ Yes' : 'No' }}
                                </button>
                            </form>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('admin.listings.toggleSold', $listing) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $listing->is_sold ? 'bg-red-50 text-red-700 border-red-300 hover:bg-red-100' : 'bg-green-50 text-green-700 border-green-300 hover:bg-green-100' }}"
                                >
                                    {{ $listing->is_sold ? 'Sold' : 'Active' }}
                                </button>
                            </form>
                        </td>

                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.listings.destroy', $listing) }}"
                                  onsubmit="return confirm('Delete this listing permanently? This cannot be undone.')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm font-medium hover:text-red-800 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            No listings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $listings->links() }}
    </div>
</x-layouts.admin>
