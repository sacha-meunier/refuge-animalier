@props(['show' => false])

<div>
    {{-- Backdrop --}}
    <div
        x-show="{{ $show ? 'true' : '$wire.showFilters' }}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$dispatch('toggle-filters')"
        class="fixed inset-0 z-[9]"
    ></div>

    {{-- Popover --}}
    <div class="relative">
        <div
            x-show="{{ $show ? 'true' : '$wire.showFilters' }}"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-6 top-2 z-10 w-72 bg-card border border-border rounded-lg shadow-lg p-4"
        >
            {{ $slot }}
        </div>
    </div>
</div>
