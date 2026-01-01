<?php

use Livewire\Component;

new class extends Component {
    public string $tag = "td"; // 'th' or 'td'
    public string $type = "text"; // checkbox, avatar-text, badge, button, text
    public mixed $content = null;
    public bool $muted = false;
    public bool $sortable = false;
    public string $sortField = ""; // Field name for sorting
    public string $sortDirection = ""; // 'asc', 'desc', or ''

    // Additional properties for specific cell types
    public ?string $avatar = null; // For avatar-text type
    public ?string $badgeVariant = "default"; // For badge type
    public ?string $badgeColor = null; // For badge type - custom color classes from enum
};
?>

@php
    $tagName = $tag === "th" ? "th" : "td";
    $baseClasses = $tag === "th" ? "px-4 text-left text-xs font-medium text-muted-foreground tracking-wider" : "px-4";

    // Add cursor pointer and hover effect if sortable
    if ($sortable && $tag === "th") {
        $baseClasses .= " cursor-pointer hover:bg-muted/50 transition-colors select-none";
    }
@endphp

<{{ $tagName }}
    {{ $attributes->merge(["class" => $baseClasses]) }}
    @if ($sortable && $tag === "th" && $sortField)
        wire:click="$parent.sortBy('{{ $sortField }}')"
    @endif
>
    @if ($tag === "th")
        @if ($sortable)
            <div class="flex items-center gap-2">
                @if ($type === "checkbox")
                    <x-checkbox />
                @elseif ($type === "text")
                    <span class="text-sm font-medium">{{ $content }}</span>
                @endif

                @if ($sortField)
                    <span class="inline-flex">
                        <x-svg.sort direction="{{ $sortDirection }}" />
                    </span>
                @endif
            </div>
        @else
            @if ($type === "checkbox")
                <x-checkbox />
            @elseif ($type === "text")
                <span class="text-sm font-medium">{{ $content }}</span>
            @endif
        @endif
    @else
        @switch($type)
            @case("checkbox")
                <x-checkbox />

                @break
            @case("avatar-text")
                <x-avatar-text :avatar="$avatar" :muted="$muted">
                    {{ $content }}
                </x-avatar-text>

                @break
            @case("avatar")
                <x-avatar-text :muted="$muted">
                    {{ $content }}
                </x-avatar-text>

                @break
            @case("badge")
                <x-badge :variant="$badgeVariant" :color="$badgeColor">
                    {{ $content }}
                </x-badge>

                @break
            @case("button")
                @if ($slot)
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="p-2 hover:bg-muted rounded-md transition-colors"
                        >
                            <x-svg.elipsis-horizontal />
                        </button>
                        <x-popover align="right">
                            {{ $slot }}
                        </x-popover>
                    </div>
                @else
                    <button
                        class="p-1 hover:bg-muted rounded transition-colors"
                    >
                        <x-svg.elipsis-horizontal />
                    </button>
                @endif

                @break
            @case("text")
            @default
                <span
                    class="text-sm {{ $muted ? "text-muted-foreground" : "font-medium" }}"
                >
                    {{ $content }}
                </span>

                @break
        @endswitch
    @endif
</{{ $tagName }}>
