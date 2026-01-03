@props(['href', 'active' => false])

@php
    $classes = $active
        ? 'bg-accent text-accent-foreground font-medium'
        : 'text-muted-foreground hover:bg-accent/40 hover:text-accent-foreground transition-colors';
@endphp

<a
    href="{{ $href }}"
    class="{{ $classes }} px-4 py-2 rounded-full text-sm select-none"
    {{ $attributes }}
>
    {{ $slot }}
</a>
