<x-layouts.public>
    <h1 class="text-xl font-semibold mb-4">Edit profile</h1>

    <form class="bg-white border rounded p-4 space-y-4" method="POST" action="{{ route('profiles.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Username</label>
            <input class="w-full border rounded p-2" name="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div>
            <label class="block font-medium">Birthday (optional)</label>
            <input class="w-full border rounded p-2" type="date" name="birthday" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}">
        </div>

        <div>
            <label class="block font-medium">Bio (optional)</label>
            <textarea class="w-full border rounded p-2" name="bio" rows="5">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="block font-medium">Profile photo</label>
            @if($user->profile_photo_path)
                <img class="max-w-xs rounded border" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Profile photo">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remove_photo" value="1">
                    <span>Remove current photo</span>
                </label>
            @endif
            <input type="file" name="profile_photo" accept="image/*">
        </div>

        <button class="px-3 py-2 bg-black text-white rounded">Save</button>
    </form>
</x-layouts.public>
