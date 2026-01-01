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
    $baseClasses =
        $tag === "th"
            ? "px-4 text-left text-xs font-medium text-muted-foreground tracking-wider"
            : "px-4";

    $textClasses = $muted ? "text-muted-foreground" : "";

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
    @if ($sortable && $tag === "th")
        <div class="flex items-center gap-2">
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
                    @if ($slot)
                        {{-- Button with popover --}}
                        <div x-data="{ open: false }" class="relative">
                            {{-- Trigger button --}}
                            <button
                                @click="open = !open"
                                class="p-2 hover:bg-muted rounded-md transition-colors"
                            >
                                <x-svg.elipsis-horizontal />
                            </button>

                            {{-- Popover --}}
                            <x-popover align="right">
                                {{ $slot }}
                            </x-popover>
                        </div>
                    @else
                        {{-- Simple button without popover --}}
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

            {{-- Sort indicator --}}
            @if ($sortField)
                <span class="inline-flex">
                    @if ($sortDirection === "asc")
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 15l7-7 7 7"
                            />
                        </svg>
                    @elseif ($sortDirection === "desc")
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    @else
                        <svg
                            class="w-4 h-4 opacity-30"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                            />
                        </svg>
                    @endif
                </span>
            @endif
        </div>
    @else
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
                @if ($slot)
                    {{-- Button with popover --}}
                    <div x-data="{ open: false }" class="relative">
                        {{-- Trigger button --}}
                        <button
                            @click="open = !open"
                            class="p-2 hover:bg-muted rounded-md transition-colors"
                        >
                            <x-svg.elipsis-horizontal />
                        </button>

                        {{-- Popover --}}
                        <x-popover align="right">
                            {{ $slot }}
                        </x-popover>
                    </div>
                @else
                    {{-- Simple button without popover --}}
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
