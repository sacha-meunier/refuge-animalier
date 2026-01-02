@props([
    "variant" => "default", // 'default' or 'destructive'
])

@php
    $baseClasses = "w-full text-left px-2 py-2 text-sm rounded flex items-center gap-2.5 cursor-pointer";

    $variantClasses = match ($variant) {
        "destructive" => "text-destructive hover:bg-destructive/10",
        default => "text-popover-foreground hover:bg-muted",
    };

    $classes = $baseClasses . " " . $variantClasses;
@endphp

<button {{ $attributes->merge(["class" => $classes]) }}>
    {{ $slot }}
</button>
