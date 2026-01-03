@props([
    "old_page" => "",
    "current_page" => "",
])

<div class="h-14 pl-7 pr-3.5 flex items-center justify-between border-b border-border">
    {{-- Breadcrumb --}}
    <x-breadcrumb :old_page="$old_page" :current_page="$current_page" />

    {{-- Close button --}}
    <x-button
        @click="open = false; $dispatch('close-modal')"
        variant="ghost"
        size="sm"
    >
        <x-svg.close />
    </x-button>
</div>
