<?php

use Livewire\Component;

new class extends Component
{
    public string $content = "Search";
};
?>

<div class="max-w-80 h-8 relative">
    <x-svg.search class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" size="sm"/>

    <input
        type="text"
        placeholder="{{ $content }}"
        class="w-full h-full pl-8 pr-4 border border-border rounded-lg bg-background text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
    />
</div>
