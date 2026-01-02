@props(['content'])

<button
    type="button"
    {{ $attributes->merge(['class' => 'flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground transition-colors']) }}
    x-data="{
        copied: false,
        supported: !!(navigator.clipboard && navigator.clipboard.writeText),
        copy() {
            navigator.clipboard.writeText('{{ $content }}');
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }"
    x-show="supported"
    x-cloak
    @click="copy"
>
    <span x-show="!copied">{{ __("pages/adoptions/show.copy") }}</span>
    <span x-show="copied" class="text-green-500">Copié !</span>

    <template x-if="!copied">
        <x-svg.copy size="sm" />
    </template>

    <template x-if="copied">
        <x-svg.check size="sm" class="text-green-500" />
    </template>
</button>
