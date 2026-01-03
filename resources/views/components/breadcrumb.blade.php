@props([
    "old_page" => "",
    "current_page" => "",
])

<div class="flex items-center gap-2">
    <span class="text-sm text-muted-foreground">
        {{ $old_page }}
    </span>
    @if ($current_page)
        <x-svg.chevron-right class="h-4 w-4 text-muted-foreground" />
        <span class="text-sm font-medium truncate">
            {{ $current_page }}
        </span>
    @endif
</div>
