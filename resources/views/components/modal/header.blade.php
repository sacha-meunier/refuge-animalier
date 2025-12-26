@props([
    "breadcrumb" => [],
])

<div
    class="h-14 px-3.5 flex items-center justify-between border-b border-border"
>
    {{-- Breadcrumb --}}
    <x-breadcrumb :breadcrumb="$breadcrumb"/>

    {{-- Close button --}}
    <x-button @click="open = false" variant="ghost" size="sm">
        <x-svg.close/>
    </x-button>
</div>
