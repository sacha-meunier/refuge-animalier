@props([
    'tag' => 'td',
    'type' => 'text',
    'content' => null,
    'muted' => false,
    'sortable' => false,
    'sortField' => '',
    'sortDirection' => '',
    'avatar' => null,
    'badgeVariant' => 'default',
    'badgeColor' => null,
])

@php
    $tagName = $tag === 'th' ? 'th' : 'td';
    $baseClasses = $tag === 'th' ? 'px-4 text-left text-xs font-medium text-muted-foreground tracking-wider' : 'px-4';

    if ($sortable && $tag === 'th') {
        $baseClasses .= ' cursor-pointer hover:bg-muted/50 transition-colors select-none';
    }
@endphp

<{{ $tagName }}
    {{ $attributes->merge(['class' => $baseClasses]) }}
    @if ($sortable && $tag === 'th' && $sortField)
        wire:click="sortBy('{{ $sortField }}')"
    @endif
>
    @if ($tag === 'th')
        @if ($sortable)
            <div class="flex items-center gap-2">
                @if ($type === 'checkbox')
                    <x-checkbox />
                @elseif ($type === 'text')
                    <span class="text-sm font-medium">{{ $content }}</span>
                @endif

                @if ($sortField)
                    <span class="inline-flex">
                        <x-svg.sort direction="{{ $sortDirection }}" />
                    </span>
                @endif
            </div>
        @else
            @if ($type === 'checkbox')
                <x-checkbox />
            @elseif ($type === 'text')
                <span class="text-sm font-medium">{{ $content }}</span>
            @endif
        @endif
    @else
        @switch($type)
            @case('checkbox')
                <x-checkbox />
                @break

            @case('avatar-text')
                <x-avatar-text :avatar="$avatar" :muted="$muted">
                    {{ $content }}
                </x-avatar-text>
                @break

            @case('avatar')
                <x-avatar-text :muted="$muted">
                    {{ $content }}
                </x-avatar-text>
                @break

            @case('badge')
                <x-badge :variant="$badgeVariant" :color="$badgeColor">
                    {{ $content }}
                </x-badge>
                @break

            @case('button')
                @if ($slot->isNotEmpty())
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
                    <button class="p-1 hover:bg-muted rounded transition-colors">
                        <x-svg.elipsis-horizontal />
                    </button>
                @endif
                @break

            @case('text')
            @default
                <span class="text-sm {{ $muted ? 'text-muted-foreground' : 'font-medium' }}">
                    {{ $content }}
                </span>
                @break
        @endswitch
    @endif
</{{ $tagName }}>
