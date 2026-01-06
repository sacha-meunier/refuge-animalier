@props([
    "route",
    "page",
    "icon" => null,
])

<a
    href="{{ $route }}"
    wire:navigate
    class="flex items-center gap-2 text-sm capitalize h-8 px-2 transition-all duration-150 rounded-lg hover:bg-sidebar-accent/60 hover:text-sidebar-accent-foreground {{
        request()->routeIs("{$page}.*")
            ? "bg-sidebar-accent text-sidebar-accent-foreground"
            : "text-shadow-sidebar-foreground"
    }}"
>
    @if (! is_null($icon))
        <x-dynamic-component
            class="text-muted-foreground"
            :component="'svg.'.$icon"
        />
    @endif

    <span class="translate-y-0.5">
        {{ __("components." . $page) }}
    </span>
</a>
