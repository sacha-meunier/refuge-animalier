@props(["hover" => false])

@php
    $id = $attributes->get("id", "checkbox-" . uniqid());
@endphp

<div class="inline-flex items-center">
    <input
        type="checkbox"
        id="{{ $id }}"
        {{ $attributes->except(["class", "hover"])->class(["peer sr-only"]) }}
    />
    <label
        for="{{ $id }}"
        @if ($hover)
            :class="hoverAll ? 'border-primary/50' : 'border-muted-foreground/30 hover:border-primary/50'"
        @endif
        class="w-4 h-4 rounded border-2 @if(!$hover) border-muted-foreground/30 hover:border-primary/50 @endif bg-background cursor-pointer transition-all peer-focus:ring-2 peer-focus:ring-primary/20 peer-focus:ring-offset-0 peer-checked:bg-primary peer-checked:border-primary relative flex items-center justify-center"
    >
        <svg
            class="w-3 h-3 text-primary-foreground opacity-0 peer-checked:opacity-100 transition-opacity absolute"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                d="M5 13l4 4L19 7"
            />
        </svg>
    </label>
</div>
