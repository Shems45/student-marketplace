@props(['variant' => 'primary', 'type' => 'submit'])

@php
$base = 'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2';
$variants = [
  'primary' => 'bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-900',
  'secondary' => 'bg-white border border-gray-200 text-gray-900 hover:bg-gray-50 focus:ring-gray-300',
  'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-600',
  'link' => 'bg-transparent text-gray-900 underline hover:text-gray-700 focus:ring-gray-300 px-0 py-0',
];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base.' '.$variants[$variant]]) }}>
    {{ $slot }}
</button>
