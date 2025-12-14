@props([
    'size' => 'base',
    'strokeWidth' => '2',
])

@php
    // Size mapping
    $sizeClasses = match($size) {
        'xs' => 'size-3',
        'sm' => 'size-4',
        'base' => 'size-5',
        'md' => 'size-6',
        'lg' => 'size-8',
        'xl' => 'size-10',
        '2xl' => 'size-12',
        default => $size, // Allow custom size like 'size-16' or 'w-6 h-6'
    };
@endphp

<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="{{ $strokeWidth }}"
    stroke-linecap="round"
    stroke-linejoin="round"
    class="{{ $sizeClasses }} {{ $attributes->get('class') }}"
    aria-hidden="true"
    {{ $attributes->except(['class']) }}
>
    {{ $slot }}
</svg>
