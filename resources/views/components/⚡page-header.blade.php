<?php

use Livewire\Component;

new class extends Component {
    public string $title = "Title";
    public bool $showAction = false;
    public ?string $actionLabel = null;
    public ?string $actionPermission = null;
    public mixed $actionModel = null;
};
?>

<header class="h-14 px-6 flex items-center justify-between border-b border-border">
    <div class="flex items-center gap-2 text-sm">
        <span class="font-medium">
            {{ $title }}
        </span>
        <x-svg.chevron-right class="text-muted-foreground"/>
    </div>

    @if($showAction && $actionLabel && $actionPermission && $actionModel)
        @can($actionPermission, $actionModel)
            <x-button type="button" variant="primary" size="sm">
                {{ $actionLabel }}
            </x-button>
        @endcan
    @endif
</header>
