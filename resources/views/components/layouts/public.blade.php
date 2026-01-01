<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Student Marketplace') : config('app.name', 'Student Marketplace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6 h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg text-gray-900 hover:text-gray-700 transition whitespace-nowrap">
                    <span class="text-2xl">📚</span>
                    <span class="hidden sm:inline">Student Marketplace</span>
                </a>

                <!-- Center Nav -->
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-700">
                    <a href="{{ route('listings.index') }}" class="hover:text-gray-900 transition">Listings</a>
                    <a href="{{ route('news.index') }}" class="hover:text-gray-900 transition">News</a>
                    <a href="{{ route('faq.index') }}" class="hover:text-gray-900 transition">FAQ</a>
                    <a href="{{ route('contact.create') }}" class="hover:text-gray-900 transition">Contact</a>
                </nav>

                <!-- Auth Actions (Right) -->
                <div class="flex items-center gap-2 sm:gap-3 ml-auto">
                    @auth
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

                        <a href="{{ route('conversations.index') }}" class="relative inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                            <span class="text-lg">💬</span>
                            @if($unread > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center h-5 min-w-[20px] px-1 bg-red-500 text-white text-[10px] font-semibold rounded-full">
                                    {{ min($unread, 9) }}{{ $unread > 9 ? '+' : '' }}
                                </span>
                            @endif
                        </a>

                        <details class="relative" role="list" aria-label="Profile menu">
                            <summary class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition cursor-pointer list-none marker:hidden">
                                <span class="hidden sm:inline">{{ auth()->user()->username }}</span>
                                <span class="text-xs">▾</span>
                            </summary>
                            <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md py-1 z-50">
                                <a href="{{ route('profiles.show', auth()->user()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Profile</a>
                                <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Favorites</a>
                                <a href="{{ route('listings.mine') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">My listings</a>
                                <a href="{{ route('listings.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Create listing</a>
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.listings.index') }}" class="block px-4 py-2 text-sm text-amber-700 font-semibold hover:bg-amber-50 border-b border-gray-100">⚙️ Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                </form>
                            </div>
                        </details>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 transition font-semibold">Log in</a>
                        <a href="{{ route('register') }}" class="px-3 sm:px-4 py-2 bg-sky-600 text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-sky-700 transition whitespace-nowrap shadow-sm">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('status'))
        <div class="bg-green-50 border-b border-green-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-start gap-3">
                    <span class="text-green-600 text-lg">✓</span>
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-amber-50 border-b border-amber-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-start gap-3">
                    <span class="text-amber-600 text-lg">!</span>
                    <p class="text-sm text-amber-800">{{ session('warning') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-start gap-3">
                    <span class="text-red-600 text-lg">✕</span>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 bg-gray-50 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('listings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Listings</a></li>
                        <li><a href="{{ route('conversations.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Messages</a></li>
                        <li><a href="{{ route('listings.create') }}" class="text-sm text-gray-600 hover:text-gray-900">Create Listing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('news.index') }}" class="text-sm text-gray-600 hover:text-gray-900">News</a></li>
                        <li><a href="{{ route('faq.index') }}" class="text-sm text-gray-600 hover:text-gray-900">FAQ</a></li>
                        <li><a href="{{ route('contact.create') }}" class="text-sm text-gray-600 hover:text-gray-900">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">About</h4>
                    <p class="text-sm text-gray-600">A student marketplace for buying and selling textbooks, notes, and study materials.</p>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-6 text-center">
                <p class="text-sm text-gray-600">&copy; 2025 Student Marketplace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
