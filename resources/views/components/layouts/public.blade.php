<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Student Marketplace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-semibold">Marketplace</a>

            <div class="flex gap-4 items-center">
                <a href="{{ route('news.index') }}">News</a>
                <a href="{{ route('listings.index') }}">Listings</a>
                <a href="{{ route('faq.index') }}">FAQ</a>
                <a href="{{ route('contact.create') }}">Contact</a>

                @auth
                    <a href="{{ route('listings.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Create Listing</a>
                    
                    @php
                        $unread = \App\Models\Conversation::query()
                            ->where(function ($q) {
                                $q->where('buyer_id', auth()->id())
                                  ->orWhere('seller_id', auth()->id());
                            })
                            ->get()
                            ->sum(function ($c) {
                                $lastRead = $c->lastReadAtFor(auth()->id());
                                return $c->messages
                                    ->where('sender_id', '!=', auth()->id())
                                    ->filter(fn($m) => $lastRead === null || $m->created_at->gt($lastRead))
                                    ->count();
                            });
                    @endphp
                    
                    <a href="{{ route('conversations.index') }}" class="relative">
                        Messages
                        @if($unread > 0)
                            <span class="ml-1 px-2 py-0.5 text-xs bg-red-600 text-white rounded-full font-semibold">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                    
                    <a href="{{ route('listings.mine') }}">My Listings</a>
                    <a href="{{ route('profiles.show', auth()->user()) }}">My profile</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        <x-flash-message />
        {{ $slot }}
    </main>
</body>
</html>
