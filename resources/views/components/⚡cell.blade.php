<?php

use Livewire\Component;

new class extends Component {
    public string $tag = "td"; // 'th' or 'td'
    public string $type = "text"; // checkbox, avatar-text, badge, button, text
    public mixed $content = null;
    public bool $muted = false;
    public bool $sortable = false; // For future use
    public string $sortDirection = ""; // 'asc', 'desc', or ''

    // Additional properties for specific cell types
    public ?string $avatar = null; // For avatar-text type
    public ?string $badgeVariant = "default"; // For badge type
    public ?string $badgeColor = null; // For badge type - custom color classes from enum
};
?>

@php
    $tagName = $tag === "th" ? "th" : "td";
    $baseClasses =
        $tag === "th"
            ? "px-4 text-left text-xs font-medium text-muted-foreground tracking-wider"
            : "px-4";

    $textClasses = $muted ? "text-muted-foreground" : "";
@endphp

<{{ $tagName }} {{ $attributes->merge(["class" => $baseClasses]) }}>
    @switch($type)
        @case("checkbox")
            <input
                type="checkbox"
                class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer"
            />

            @break
        @case("avatar-text")
            <div class="flex items-center gap-3">
                @if ($avatar)
                    <div
                        class="w-10 h-10 rounded-full bg-muted flex items-center justify-center text-xl"
                    >
                        {{ $avatar }}
                    </div>
                @endif

                <span class="text-sm font-medium {{ $textClasses }}">
                    {{ $content }}
                </span>
            </div>

            @break
        @case("avatar")
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium {{ $textClasses }}">
                    {{ $content }}
                </span>
            </div>

            @break
        @case("badge")
            @php
                if ($badgeColor) {
                    $badgeClasses = $badgeColor;
                } else {
                    $badgeClasses = match ($badgeVariant) {
                        "success" => "bg-badge-success text-badge-success-foreground",
                        "warning" => "bg-badge-warning text-badge-warning-foreground",
                        "danger" => "bg-badge-danger text-badge-danger-foreground",
                        "info" => "bg-badge-info text-badge-info-foreground",
                        default => "bg-badge-neutral text-badge-neutral-foreground",
                    };
                }
            @endphp

            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClasses }}"
            >
                {{ $content }}
            </span>

            @break
        @case("button")
            {{-- TODO update existing button component to use icons --}}
            <button class="p-1 hover:bg-muted rounded transition-colors">
                @if ($content)
                    {{ $content }}
                @else
                    <x-svg.elipsis-horizontal />
                @endif
            </button>

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
</{{ $tagName }}>
