<x-layouts.admin>
    <h1 class="text-3xl font-bold mb-6">Create User</h1>

    <x-flash-message />

    <form class="bg-white shadow rounded p-6 space-y-4 max-w-md" method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div>
            <label class="block font-medium mb-1">Username <span class="text-red-500">*</span></label>
            <input class="w-full border-gray-300 rounded shadow-sm" name="username" value="{{ old('username') }}" required minlength="3">
            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Email <span class="text-red-500">*</span></label>
            <input class="w-full border-gray-300 rounded shadow-sm" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Password <span class="text-red-500">*</span></label>
            <input class="w-full border-gray-300 rounded shadow-sm" type="password" name="password" required minlength="8">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin')) class="rounded border-gray-300">
            <span class="font-medium">Make this user admin</span>
        </label>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
