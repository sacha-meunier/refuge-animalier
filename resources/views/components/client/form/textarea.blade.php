@props([
    "name",
    "label",
    "placeholder" => "",
    "required" => false,
    "value" => "",
    "rows" => 5,
])

<div class="space-y-2">
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-foreground select-none"
    >
        {{ $label }}
    </label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        spellcheck="true"
        autocomplete="off"
        @if($required) required @endif
        {{ $attributes->merge(["class" => "w-full px-4 py-2.5 bg-background border border-border/60 rounded-lg text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-none touch-target text-base"]) }}
    >
{{ old($name, $value) }}</textarea
    >
</div>
