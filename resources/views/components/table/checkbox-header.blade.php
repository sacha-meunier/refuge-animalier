@props([
    'selectAll' => false,
])

<th class="w-12 pl-6 pr-4 text-left text-xs font-medium text-muted-foreground tracking-wider">
    <input
        type="checkbox"
        class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer hover:ring-2 hover:ring-primary/50 transition-all"
        wire:model.live="selectAll"
        @mouseenter="hoverAll = true"
        @mouseleave="hoverAll = false"
    />
</th>
