<?php

use Livewire\Component;

/*
 * $searchPlaceholder defines the placeholder of the search input.
 * $showFilters allows to display or not the filters button in the action bar.
 * $showAction allows to display or not the action (ex : add a member) button in the action bar.
 * $actionLabel defines the content of the action button.
 * $actionPermission defines the type of permission required to use the action button (ex : create, update, delete). This is tied to policies.
 * $actionModel defines the model tied to the policy to handle the required permission.
 * */
new class extends Component {
    public string $searchPlaceholder = "Search";
    public bool $showFilters = true;
    public bool $showAction = false;
    public ?string $actionLabel = null;
    public ?string $actionPermission = null;
    public mixed $actionModel = null;
};
?>

<div class="h-14 px-6 flex items-center justify-between border-b border-border">
    {{-- Search Input --}}
    <livewire:search :content="$searchPlaceholder"/>

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        @if($showFilters)
            <x-button type="button" variant="outline" size="sm">
                Filters
            </x-button>
        @endif

        @if($showAction && $actionLabel && $actionPermission && $actionModel)
            @can($actionPermission, $actionModel)
                <x-button type="button" variant="primary" size="sm">
                    {{ $actionLabel }}
                </x-button>
            @endcan
        @endif
    </div>
</div>
