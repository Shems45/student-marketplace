@props(['label' => null, 'name' => null, 'type' => 'text'])

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-900 mb-1">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2']) }}
    />
    @error($name)
        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
    @enderror
</div>
