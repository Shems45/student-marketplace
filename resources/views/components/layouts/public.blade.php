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
