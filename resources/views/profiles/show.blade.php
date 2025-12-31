<x-layouts.public title="{{ $user->username }}'s Profile">
    <div class="max-w-4xl mx-auto px-4 py-8">
        @auth
            <div class="mb-6 flex gap-4">
                @if(auth()->id() === $user->id)
                    <a class="text-blue-600 hover:underline" href="{{ route('profiles.edit', $user) }}">Edit my profile</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        @endauth

        @guest
            <div class="mb-6 flex gap-4">
                <a class="text-blue-600 hover:underline" href="{{ route('login') }}">Login</a>
                <a class="text-blue-600 hover:underline" href="{{ route('register') }}">Register</a>
            </div>
        @endguest

        <h1 class="text-3xl font-bold mb-2">{{ $user->username }}</h1>

        <div class="text-sm text-gray-600 mb-6">
            @if($user->birthday)
                Birthday: {{ $user->birthday->format('Y-m-d') }}
            @endif
        </div>

        <div class="flex gap-6 items-start">
            <div class="w-48">
                @if($user->profile_photo_path)
                    <img class="rounded border shadow" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Profile photo">
                @else
                    <div class="rounded border bg-white p-6 text-center text-gray-600">No photo</div>
                @endif
            </div>

            <div class="flex-1">
                <div class="bg-white shadow rounded p-6">
                    <h2 class="font-bold text-lg mb-2">About</h2>
                    <p class="whitespace-pre-line text-gray-700">{{ $user->bio ?? 'No bio yet.' }}</p>
                </div>

                <div class="mt-6 bg-white shadow rounded p-6">
                    <h2 class="font-bold text-lg mb-4">Latest listings</h2>

                    @if($user->listings->isEmpty())
                        <div class="text-gray-500">No listings yet.</div>
                    @else
                        <div class="space-y-3">
                            @foreach($user->listings as $listing)
                                <a class="block border rounded p-3 hover:bg-gray-50 transition" href="{{ route('listings.show', $listing) }}">
                                    <div class="font-semibold">{{ $listing->title }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $listing->created_at->format('F j, Y') }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
