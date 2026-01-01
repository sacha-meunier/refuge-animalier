@props([
    'direction' => '',
])

@php
    $baseClasses = 'transform transition-all duration-200 origin-center';

    $directionClasses = [
        '' => 'opacity-30 rotate-0',
        'asc' => 'opacity-100 rotate-180',
        'desc' => 'opacity-100 rotate-0',
    ];

    $classes = $baseClasses . ' ' . ($directionClasses[$direction] ?? $directionClasses['']);
@endphp

<x-svg.base {{ $attributes->merge(['class' => $classes]) }}>
    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
</x-svg.base>
