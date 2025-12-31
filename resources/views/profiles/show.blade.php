<x-layouts.public>
    <h1 class="text-2xl font-semibold">{{ $user->username }}</h1>

    <div class="text-sm text-gray-600 mb-4">
        @if($user->birthday)
            Birthday: {{ $user->birthday->format('Y-m-d') }}
        @endif
    </div>

    <div class="flex gap-6 items-start">
        <div class="w-48">
            @if($user->profile_photo_path)
                <img class="rounded border" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Profile photo">
            @else
                <div class="rounded border bg-white p-6 text-center text-gray-600">No photo</div>
            @endif
        </div>

        <div class="flex-1">
            <div class="bg-white border rounded p-4">
                <h2 class="font-semibold mb-2">About</h2>
                <p class="whitespace-pre-line">{{ $user->bio ?? 'No bio yet.' }}</p>

                @auth
                    @if(auth()->id() === $user->id)
                        <div class="mt-3">
                            <a class="underline" href="{{ route('profiles.edit') }}">Edit my profile</a>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="mt-6 bg-white border rounded p-4">
                <h2 class="font-semibold mb-2">Latest listings</h2>

                @if($user->listings->isEmpty())
                    <div class="text-gray-600">No listings yet.</div>
                @else
                    <div class="space-y-2">
                        @foreach($user->listings as $listing)
                            <a class="block border rounded p-3 hover:bg-gray-50" href="{{ route('listings.show', $listing) }}">
                                <div class="font-medium">{{ $listing->title }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ $listing->created_at->format('Y-m-d') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.public>
