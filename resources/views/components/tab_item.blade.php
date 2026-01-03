@props([
    "tabname",
    "activetab",
])

<button
    wire:click="$set('activeTab', '{{ $tabname }}')"
    type="button"
    class="h-7 px-2 font-medium text-sm rounded-xl {{
        $activetab === $tabname ? "bg-background text-foreground" : "bg-background/0 text-muted-foreground"
    }}"
>
    {{ $slot }}
</button>
