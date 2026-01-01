@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl shadow-sm']) }}>
    @if($title)
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
        </div>
    @endif

    <div class="px-5 py-5">
        {{ $slot }}
    </div>
</div>
