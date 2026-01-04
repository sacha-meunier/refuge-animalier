@props([
    "type" => "submit",
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(["class" => "px-4 py-2 bg-primary text-primary-foreground rounded-full text-sm font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-colors select-none touch-target"]) }}
>
    {{ $slot }}
</button>
