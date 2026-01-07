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
    public string $searchPlaceholder = "";
    public bool $showFilters = true;
    public bool $showAction = false;
    public ?string $actionLabel = null;
    public ?string $actionPermission = null;
    public mixed $actionModel = null;

    public function mount()
    {
        if (empty($this->searchPlaceholder)) {
            $this->searchPlaceholder = __("components.search");
        }
    }
};
?>

<div>
    <div class="h-14 px-6 flex items-center justify-between border-b border-border">
        {{-- Search Input --}}
        <livewire:search :content="$searchPlaceholder" />

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            @if ($showFilters)
                <x-button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="$dispatch('toggle-filters')"
                >
                    {{ __("components.filters") }}
                </x-button>
            @endif

            @if ($showAction && $actionLabel && $actionPermission && $actionModel)
                @can($actionPermission, $actionModel)
                    <x-button
                        type="button"
                        variant="primary"
                        size="sm"
                        @click="$dispatch('open-create-modal')"
                    >
                        {{ $actionLabel }}
                    </x-button>
                @endcan
            @endif
        </div>
    </div>

    {{-- Filters Slot (hidden by default) --}}
    @if ($showFilters && isset($filters))
        <div x-data="{ open: false }" @toggle-filters.window="open = !open">
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="border-b border-border bg-muted/30"
                style="display: none"
            >
                <div class="px-6 py-4">
                    {{ $filters }}
                </div>
            </div>
        </div>
    @endif
</div>
