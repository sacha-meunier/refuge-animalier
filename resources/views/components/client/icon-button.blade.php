@props([
    "href" => null,
])

@php
    $tag = $href ? "a" : "div";
    $baseClasses = "inline-flex items-center justify-center size-9 rounded-full bg-card border border-border transition-colors hover:bg-accent touch-target";
@endphp

<{{ $tag }}
    @if($href)
        href="{{ $href }}"
    @endif
    {{ $attributes->merge(["class" => $baseClasses]) }}
>
    {{ $slot }}
</{{ $tag }}>
