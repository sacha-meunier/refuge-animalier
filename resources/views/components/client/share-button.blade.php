@props([
    "url" => "",
    "subject" => "",
    "body" => "",
])

@php
    $mailtoUrl = "mailto:?subject=" . rawurlencode($subject) . "&body=" . rawurlencode($body . " " . $url);
@endphp

<a
    href="{{ $mailtoUrl }}"
    aria-label="{{ __("client.share_animal") }}"
    {{ $attributes->merge(["class" => "inline-flex items-center gap-2 px-4 py-2 bg-secondary text-secondary-foreground rounded-full text-sm font-medium hover:bg-secondary/80 transition-colors touch-target select-none"]) }}
>
    <x-svg.share/>
    <span>{{ $slot }}</span>
</a>
