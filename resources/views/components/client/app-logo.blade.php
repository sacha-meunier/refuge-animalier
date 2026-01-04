<a
    {{ $attributes->merge(['class' => 'flex items-center gap-2 px-3 py-2 -ml-3 rounded-full hover:bg-accent/40 transition-colors select-none w-fit']) }}
    href="{{ route("home") }}"
    aria-label="{{ config("app.name") }}"
>
    <x-svg.dog size="md" class="text-foreground"/>
    <span class="text-base font-medium hidden sm:inline">
        {{ config("app.name") }}
    </span>
</a>
