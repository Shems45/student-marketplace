<x-layouts.public>
    @php
        $listingCount = \App\Models\Listing::count();
        $userCount = \App\Models\User::count();
    @endphp

    <div class="space-y-16">
        <!-- Hero -->
        <section class="relative overflow-hidden rounded-2xl border border-gray-100 bg-gradient-to-r from-sky-50 via-white to-indigo-50 shadow-sm">
            <div class="absolute -left-14 -top-16 h-48 w-48 rounded-full bg-sky-200/30 blur-3xl"></div>
            <div class="absolute -right-10 bottom-0 h-52 w-52 rounded-full bg-indigo-200/30 blur-3xl"></div>

            <div class="relative px-6 py-12 sm:px-10 sm:py-16 lg:px-16 flex flex-col gap-10 lg:flex-row lg:items-center">
                <div class="flex-1 space-y-6">
                    <p class="text-sm font-semibold text-sky-700 uppercase tracking-wide">Student to student</p>
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">Vind, koop of verkoop alles voor je studie</h1>
                    <p class="text-lg text-gray-600 max-w-2xl">Zoek tweedehands studieboeken, gadgets of meubels in een vertrouwde omgeving. Start met zoeken of plaats zelf in een minuut.</p>

                    <form action="{{ route('listings.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                        <input
                            type="text"
                            name="q"
                            placeholder="Zoek naar boeken, laptops, fietsen..."
                            class="flex-1 px-4 py-3 rounded-lg border border-gray-200 text-sm placeholder-gray-500 focus:border-sky-600 focus:ring-1 focus:ring-sky-600 bg-white shadow-sm"
                        />
                        <button type="submit" class="px-5 py-3 rounded-lg bg-sky-600 text-white font-semibold text-sm hover:bg-sky-700 transition shadow-sm">Zoeken</button>
                    </form>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                        <div class="flex items-center gap-2 px-3 py-2 bg-white/70 border border-gray-100 rounded-lg shadow-sm">
                            <span class="text-sky-600">●</span>
                            <span><strong>{{ number_format($listingCount) }}</strong> actieve listings</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-2 bg-white/70 border border-gray-100 rounded-lg shadow-sm">
                            <span class="text-indigo-600">●</span>
                            <span><strong>{{ number_format($userCount) }}</strong> studenten</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-2 bg-white/70 border border-gray-100 rounded-lg shadow-sm">
                            <span class="text-emerald-600">●</span>
                            <span>Betrouwbare chat & badges</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('listings.index') }}" class="px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">Bekijk alle listings</a>
                        @auth
                            <a href="{{ route('listings.create') }}" class="px-4 py-2.5 bg-white text-gray-900 text-sm font-semibold rounded-lg border border-gray-200 hover:border-gray-300 transition shadow-sm">Plaats een listing</a>
                        @else
                            <a href="{{ route('register') }}" class="px-4 py-2.5 bg-white text-gray-900 text-sm font-semibold rounded-lg border border-gray-200 hover:border-gray-300 transition shadow-sm">Maak een account</a>
                        @endauth
                    </div>
                </div>

                <div class="w-full max-w-md space-y-4">
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Snelle plaatsing</p>
                                <h3 class="text-lg font-semibold text-gray-900">Post in drie stappen</h3>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-sky-50 text-sky-700 rounded-full">1 min</span>
                        </div>
                        <ol class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-3"><span class="h-6 w-6 flex items-center justify-center rounded-full bg-sky-100 text-sky-700 font-semibold">1</span>Foto en titel toevoegen</li>
                            <li class="flex gap-3"><span class="h-6 w-6 flex items-center justify-center rounded-full bg-sky-100 text-sky-700 font-semibold">2</span>Prijs of "op aanvraag" instellen</li>
                            <li class="flex gap-3"><span class="h-6 w-6 flex items-center justify-center rounded-full bg-sky-100 text-sky-700 font-semibold">3</span>Direct chatten met kopers</li>
                        </ol>
                        <div class="mt-6">
                            <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition shadow-sm w-full">Start nu</a>
                        </div>
                    </div>
                    <div class="bg-white/70 border border-dashed border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        ✅ Veilige berichten, ✅ duidelijke sold-badge, ✅ snelle filters. Helemaal klaar voor een 2dehands-gevoel, maar gericht op studenten.
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Listings -->
        @if($featuredListings->isNotEmpty())
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-amber-600 uppercase tracking-wide">⭐ Uitgelicht</p>
                        <h2 class="text-2xl font-bold text-gray-900">Featured listings</h2>
                    </div>
                    <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Meer →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredListings as $listing)
                        <a href="{{ route('listings.show', $listing) }}" class="group relative bg-white border-2 border-amber-200 rounded-xl overflow-hidden hover:border-amber-300 hover:shadow-lg transition">
                            <div class="absolute top-3 left-3 z-10 px-3 py-1 text-xs font-bold bg-amber-400 text-amber-900 rounded-full shadow-sm">⭐ FEATURED</div>
                            <div class="relative h-40 bg-gray-100 overflow-hidden">
                                @if($listing->image_path)
                                    <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300" />
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-300 text-4xl">📦</div>
                                @endif
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-semibold text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $listing->category->name ?? 'Categorie' }}</span>
                                    <span class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 line-clamp-2 group-hover:text-gray-700">{{ $listing->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $listing->user->username }}</p>
                                @if($listing->location_city || $listing->location_zip)
                                    <p class="text-xs text-gray-500">📍 {{ trim(($listing->location_zip ?? '') . ' ' . ($listing->location_city ?? '')) }}</p>
                                @endif
                                <div class="pt-3 flex items-center justify-between border-t border-gray-100">
                                    <span class="text-xl font-bold text-sky-700">
                                        @if(!is_null($listing->price_cents))
                                            €{{ number_format($listing->price_cents / 100, 2) }}
                                        @else
                                            <span class="text-sm text-gray-500">Op aanvraag</span>
                                        @endif
                                    </span>
                                    @if($listing->tags->isNotEmpty())
                                        <span class="text-xs text-gray-600 bg-gray-50 border border-gray-100 px-2 py-1 rounded">{{ $listing->tags->first()->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Latest Listings -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-sky-700 uppercase tracking-wide">Nieuw binnen</p>
                    <h2 class="text-2xl font-bold text-gray-900">Laatste listings</h2>
                </div>
                <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Alles bekijken →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestListings as $listing)
                    <a href="{{ route('listings.show', $listing) }}" class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 hover:shadow-lg transition">
                        <div class="relative h-40 bg-gray-100 overflow-hidden">
                            @if($listing->image_path)
                                <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300" />
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300 text-4xl">📦</div>
                            @endif
                            @if($listing->is_sold)
                                <span class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold bg-red-500 text-white rounded-full">SOLD</span>
                            @endif
                        </div>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-semibold text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $listing->category->name ?? 'Categorie' }}</span>
                                <span class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 line-clamp-2 group-hover:text-gray-700">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $listing->user->username }}</p>
                            @if($listing->location_city || $listing->location_zip)
                                <p class="text-xs text-gray-500">📍 {{ trim(($listing->location_zip ?? '') . ' ' . ($listing->location_city ?? '')) }}</p>
                            @endif
                            <div class="pt-3 flex items-center justify-between border-t border-gray-100">
                                <span class="text-xl font-bold text-sky-700">
                                    @if(!is_null($listing->price_cents))
                                        €{{ number_format($listing->price_cents / 100, 2) }}
                                    @else
                                        <span class="text-sm text-gray-500">Op aanvraag</span>
                                    @endif
                                </span>
                                @if($listing->tags->isNotEmpty())
                                    <span class="text-xs text-gray-600 bg-gray-50 border border-gray-100 px-2 py-1 rounded">{{ $listing->tags->first()->name }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Latest News -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-sky-700 uppercase tracking-wide">Updates</p>
                    <h2 class="text-2xl font-bold text-gray-900">Laatste nieuws</h2>
                </div>
                <a href="{{ route('news.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Alles lezen →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($latestNews as $item)
                    <a href="{{ route('news.show', $item) }}" class="group bg-white border border-gray-200 rounded-xl p-4 hover:border-gray-300 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-gray-700 bg-gray-100 px-2 py-1 rounded">Nieuws</span>
                            <span class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-gray-700 mb-2 line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($item->body), 120) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.public>
