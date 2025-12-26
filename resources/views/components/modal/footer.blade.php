@props([])

<div
    class="h-14 flex items-center justify-end gap-3.5 border-t border-border px-3.5"
>
    {{-- Cancel button --}}
    <x-button type="button" variant="ghost" size="sm" @click="close()">
        {{ __("modals/modals.button_cancel") }}
    </x-button>

    {{ $slot }}
</div>
