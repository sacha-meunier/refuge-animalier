@props([
    'href' => '#',
    'variant' => 'default', // default, underline
])

@php
    $baseClasses = 'font-medium text-sm text-foreground transition-all duration-200';

    $variantClasses = [
        'default' => 'hover:text-foreground/80',
        'underline' => 'underline underline-offset-[6px] decoration-foreground/35 hover:decoration-current',
    ];

    $classes = implode(' ', [
        $baseClasses,
        $variantClasses[$variant] ?? $variantClasses['default'],
    ]);
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</a>
