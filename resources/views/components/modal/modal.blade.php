@props([
    "onClose" => null,
])

<div
    x-data="{ open: true }"
    x-show="open"
    @keyup.escape.window="open = false; $dispatch('close-modal')"
    @close-modal.window="open = false"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        class="fixed inset-0 bg-background/60"
        @click="open = false; $dispatch('close-modal')"
    ></div>

    <!-- Modal -->
    <div
        x-show="open"
        @click.stop
        class="grid grid-rows-[auto_1fr_auto] bg-card text-card-foreground rounded-lg shadow-lg fixed m-auto inset-0 w-full h-full max-w-2xl max-h-96 overflow-hidden"
    >
        {{ $slot }}
    </div>
</div>
