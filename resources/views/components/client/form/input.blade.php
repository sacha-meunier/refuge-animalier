@props([
    "type" => "text",
    "name",
    "label",
    "placeholder" => "",
    "required" => false,
    "value" => "",
    "autocomplete" => "off",
])

<div class="space-y-2">
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-foreground select-none"
    >
        {{ $label }}
    </label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        autocomplete="{{ $autocomplete }}"
        spellcheck="false"
        @if($required) required @endif
        {{ $attributes->merge(["class" => "w-full px-4 py-2.5 bg-background border border-border/60 rounded-lg text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors touch-target text-base"]) }}
    />
</div>
