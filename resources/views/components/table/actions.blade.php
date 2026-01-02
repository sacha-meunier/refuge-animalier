@props([
    "item",
    "selectedIds" => [],
    "editAction" => "editItem",
    "deleteAction" => "deleteItemOrSelected",
])

<x-cell type="button" wire:click.stop>
    @can("update", $item)
        <x-popover-item wire:click="{{ $editAction }}({{ $item->id }})">
            <x-svg.square-pen class="size-4" />
            <div class="translate-y-0.5">
            {{ __("modals/modals.button_edit") }}
            </div>
        </x-popover-item>
    @endcan

    @can("delete", $item)
        <x-popover-item
            wire:click="{{ $deleteAction }}({{ $item->id }})"
            wire:confirm="{{ count($selectedIds) ? __('modals/modals.confirm_delete_multiple') : __('modals/modals.confirm_delete') }}"
            variant="destructive"
        >
            <x-svg.trash class="size-4" />
            <div class="translate-y-0.5">
            @if (count($selectedIds) > 0)
                {{ __("modals/modals.button_delete") }}
                ({{ count($selectedIds) }})
            @else
                {{ __("modals/modals.button_delete") }}
            @endif
            </div>
        </x-popover-item>
    @endcan
</x-cell>
