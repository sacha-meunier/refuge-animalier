@props([
    'variant' => 'default',
    'color' => null,
])

@php
    if ($color) {
        $badgeClasses = $color;
    } else {
        $badgeClasses = match ($variant) {
            'success' => 'bg-badge-success text-badge-success-foreground',
            'warning' => 'bg-badge-warning text-badge-warning-foreground',
            'danger' => 'bg-badge-danger text-badge-danger-foreground',
            'info' => 'bg-badge-info text-badge-info-foreground',
            default => 'bg-badge-neutral text-badge-neutral-foreground',
        };
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$badgeClasses}"]) }}>
    {{ $slot }}
</span>
