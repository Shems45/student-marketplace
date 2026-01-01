@props(['variant' => 'default'])

@php
$map = [
  'default' => 'border border-gray-200 text-gray-700',
  'unread' => 'bg-red-600 text-white',
  'sent' => 'border border-gray-200 text-gray-700 bg-white',
  'read' => 'border border-gray-200 text-gray-700 bg-gray-50',
  'admin' => 'border border-yellow-300 text-yellow-800 bg-yellow-50',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium '.$map[$variant]]) }}>
    {{ $slot }}
</span>
