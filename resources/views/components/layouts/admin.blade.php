<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Student Marketplace') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="px-5 py-4 border-b border-gray-200">
                <div class="text-lg font-semibold">Admin</div>
                <p class="text-xs text-gray-500">Manage content and users</p>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Dashboard</a>
                <a href="{{ route('admin.listings.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.listings.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Listings</a>
                <a href="{{ route('admin.news.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.news.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">News</a>
                <a href="{{ route('admin.faq-categories.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.faq-categories.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">FAQ Categories</a>
                <a href="{{ route('admin.faq-items.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.faq-items.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">FAQ Items</a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Users</a>
                <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Contact messages</a>
            </nav>

            <div class="border-t border-gray-200 px-5 py-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-700 hover:text-gray-900">← Back to site</a>
            </div>
        </aside>

        <main class="flex-1 p-6 sm:p-8">
            <div class="max-w-6xl mx-auto space-y-4">
                <x-flash-message />
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
