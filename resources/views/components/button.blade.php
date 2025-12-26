@props([
    'type' => 'button', // button, submit, reset
    'variant' => 'primary', // primary, secondary, destructive, outline, ghost
    'size' => 'default', // sm, default, lg
    'href' => null,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-1.5 rounded-lg transition-all duration-150 font-medium cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = [
        'primary' => 'bg-primary text-primary-foreground hover:bg-primary/70',
        'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/70',
        'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/70',
        'outline' => 'border border-border hover:bg-secondary/70',
        'ghost' => 'text-foreground hover:bg-secondary/70',
    ];

    $sizeClasses = [
        'sm' => 'h-9 px-3 py-2 text-sm',
        'default' => 'h-12 px-4 py-3',
        'lg' => 'h-14 px-6 py-4 text-lg',
    ];

    $classes = implode(' ', [
        $baseClasses,
        $variantClasses[$variant] ?? $variantClasses['primary'],
        $sizeClasses[$size] ?? $sizeClasses['default'],
    ]);
@endphp

@if($href)
    <a
        href="{{ $href }}"
        wire:navigate
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif
