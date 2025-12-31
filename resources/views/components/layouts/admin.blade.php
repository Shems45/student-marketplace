<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Student Marketplace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <div class="flex">
        <aside class="w-64 min-h-screen bg-white border-r p-4">
            <div class="font-semibold mb-4">Admin panel</div>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('admin.news.index') }}">News</a>
                <a href="{{ route('admin.faq-categories.index') }}">FAQ Categories</a>
                <a href="{{ route('admin.faq-items.index') }}">FAQ Items</a>
                <a href="{{ route('admin.users.index') }}">Users</a>
                <a href="{{ route('admin.contact-messages.index') }}">Contact messages</a>
                <hr class="my-2">
                <a href="{{ route('home') }}">Back to site</a>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            <x-flash-message />
            {{ $slot }}
        </main>
    </div>
</body>
</html>
