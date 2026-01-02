@props([
    'value',
])

<td class="w-12 pl-6 pr-4" wire:click.stop>
    <input
        type="checkbox"
        class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer transition-all"
        :class="hoverAll ? 'ring-2 ring-primary/50' : 'hover:ring-2 hover:ring-primary/50'"
        value="{{ $value }}"
        wire:model.live="selectedIds"
    />
</td>
