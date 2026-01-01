@props([
    "align" => "right", // 'right' or 'left'
    "width" => "w-48",
])

@php
    $alignmentClasses = match ($align) {
        "left" => "left-0",
        "right" => "right-0",
        default => "right-0",
    };
@endphp

{{-- Invisible backdrop --}}
<div
    x-show="open"
    class="fixed inset-0 z-40 cursor-default"
    @click="open = false"
    style="display: none"
></div>

{{-- Popover content --}}
<div
    x-show="open"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    @click.stop
    {{ $attributes->merge(["class" => "absolute {$alignmentClasses} mt-2 {$width} rounded-md shadow-lg bg-popover border border-border z-50"]) }}
    style="display: none"
>
    <div class="p-1 flex flex-col gap-1" @click="open = false">
        {{ $slot }}
    </div>
</div>
