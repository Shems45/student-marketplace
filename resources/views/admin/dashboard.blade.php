<x-layouts.admin title="Admin Dashboard">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <div class="text-sm text-gray-500">Platform Overview</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['users_total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-users class="w-6 h-6 text-blue-600" />
                </div>
            </div>
        </div>

        <!-- Total Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Listings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['listings_total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-inbox-stack class="w-6 h-6 text-purple-600" />
                </div>
            </div>
        </div>

        <!-- Active Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Listings</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $stats['listings_active'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-check-circle class="w-6 h-6 text-emerald-600" />
                </div>
            </div>
        </div>

        <!-- Sold Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sold Listings</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['listings_sold'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-x-circle class="w-6 h-6 text-red-600" />
                </div>
            </div>
        </div>

        <!-- Reserved Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Reserved Listings</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['listings_reserved'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-clock class="w-6 h-6 text-orange-600" />
                </div>
            </div>
        </div>

        <!-- Featured Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Featured Listings</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $stats['listings_featured'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-star class="w-6 h-6 text-amber-600" />
                </div>
            </div>
        </div>

        <!-- Favorites -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Favorites</p>
                    <p class="text-3xl font-bold text-pink-600 mt-2">{{ $stats['favorites_total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-heart class="w-6 h-6 text-pink-600" />
                </div>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Contact Messages</p>
                    <p class="text-3xl font-bold text-sky-600 mt-2">{{ $stats['contact_total'] ?? 0 }}</p>
                    <p class="text-xs text-red-600 mt-2 font-medium">Unanswered: {{ $stats['contact_unanswered'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-envelope class="w-6 h-6 text-sky-600" />
                </div>
            </div>
        </div>

        <!-- Conversations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Conversations</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $stats['conversations_total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-indigo-600" />
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Messages</p>
                    <p class="text-3xl font-bold text-violet-600 mt-2">{{ $stats['messages_total'] ?? 0 }}</p>
                    <p class="text-xs text-orange-600 mt-2 font-medium">Unread: {{ $stats['messages_unread'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-paper-airplane class="w-6 h-6 text-violet-600" />
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.listings.index') }}" class="px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">
                Manage Listings
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition">
                Manage Users
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition">
                Contact Messages
            </a>
            <a href="{{ route('admin.news.index') }}" class="px-4 py-2.5 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition">
                News
            </a>
        </div>
    </div>
</x-layouts.admin>
