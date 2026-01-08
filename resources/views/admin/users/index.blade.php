<x-layouts.admin>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold">Users</h1>
        <a class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" href="{{ route('admin.users.create') }}">New User</a>
    </div>

    <x-flash-message />

    <form class="bg-white shadow rounded p-4 mb-4 flex gap-2" method="GET" action="{{ route('admin.users.index') }}">
        <input class="flex-1 border-gray-300 rounded shadow-sm" name="q" placeholder="Search username/email..." value="{{ $q ?? '' }}">
        <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Search</button>
    </form>

    @if($users->isEmpty())
        <p class="text-gray-500">No users found.</p>
    @else
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr class="text-left">
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">Username</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Role</th>
                        <th class="px-6 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $u->id }}</td>
                            <td class="px-6 py-4">{{ $u->username }}</td>
                            <td class="px-6 py-4">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                @if($u->is_admin)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($u->id === auth()->id())
                                    <span class="text-gray-500 text-sm">Current user</span>
                                @else
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('admin.users.toggle-admin', $u) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:underline text-sm">
                                                {{ $u->is_admin ? 'Remove Admin' : 'Make Admin' }}
                                            </button>
                                        </form>
                                        
                                        <x-confirm-modal 
                                            title="Delete User"
                                            message="Are you sure you want to delete {{ $u->username }}? This action cannot be undone."
                                            confirm-text="Delete"
                                            cancel-text="Cancel"
                                        >
                                            <x-slot name="trigger">
                                                <button type="button" class="text-red-600 hover:underline text-sm">
                                                    Delete
                                                </button>
                                            </x-slot>
                                            <x-slot name="action">
                                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                                                        Delete
                                                    </button>
                                                </form>
                                            </x-slot>
                                        </x-confirm-modal>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</x-layouts.admin>
