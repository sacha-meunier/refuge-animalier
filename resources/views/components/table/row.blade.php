@props([
    'item',
    'showAction' => 'showItem',
])

<tr
    {{ $attributes->merge(['class' => 'h-14 hover:bg-muted/50 cursor-pointer']) }}
    wire:key="row-{{ $item->id }}-{{ $item->updated_at->timestamp }}"
    wire:click="{{ $showAction }}({{ $item->id }})"
>
    {{ $slot }}
</tr>
