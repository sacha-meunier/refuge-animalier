<?php

use App\Models\Specie;
use App\Models\Breed;
use App\Models\Vaccine;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url(as: "tab")]
    public string $activeTab = "species";

    public function mount(): void
    {
        // Ensure activeTab is valid
        if (! in_array($this->activeTab, ["species", "breeds", "vaccines"])) {
            $this->activeTab = "species";
        }
    }
};
?>

<div class="w-full">
    <header class="h-14 px-6 flex items-center gap-2 border-b border-border">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm">
            <span class="font-medium">
                {{ __("pages/database/index.title") }}
            </span>
            <x-svg.chevron-right class="text-muted-foreground" />
        </div>

        {{-- Tabs Navigation --}}
        <nav
            class="flex items-center p-1 bg-accent rounded-xl"
            aria-label="Tabs"
        >
            {{-- Species Tab --}}
            @can("view-any", Specie::class)
                <x-tab_item tabname="species" activetab="{{ $activeTab }}">
                    {{ __("pages/database/index.label_tabs_species") }}
                </x-tab_item>
            @endcan

            {{-- Breeds Tab --}}
            @can("view-any", Breed::class)
                <x-tab_item tabname="breeds" activetab="{{ $activeTab }}">
                    {{ __("pages/database/index.label_tabs_breeds") }}
                </x-tab_item>
            @endcan

            {{-- Vaccines Tab --}}
            @can("view-any", Vaccine::class)
                <x-tab_item tabname="vaccines" activetab="{{ $activeTab }}">
                    {{ __("pages/database/index.label_tabs_vaccines") }}
                </x-tab_item>
            @endcan
        </nav>
    </header>

    {{-- Tab Content --}}
    <main>
        @switch($activeTab)
            @case("species")
                {{-- Search and Actions Bar --}}
                <livewire:actions-bar
                    searchPlaceholder="{{ __('pages/database/index.label_search_species') }}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_species') }}"
                    actionPermission="create"
                    actionModel="{{ Specie::class }}"
                />
                <livewire:tables.species />

                @break
            @case("breeds")
                {{-- Search and Actions Bar --}}
                <livewire:actions-bar
                    searchPlaceholder="{{ __('pages/database/index.label_search_breeds') }}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_breeds') }}"
                    actionPermission="create"
                    actionModel="{{ Breed::class }}"
                />
                <livewire:tables.breeds />

                @break
            @case("vaccines")
                {{-- Search and Actions Bar --}}
                    <livewire:actions-bar
                    searchPlaceholder="{{ __('pages/database/index.label_search_vaccines') }}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_vaccines') }}"
                    actionPermission="create"
                    :actionModel="Specie::class"
                    />

                {{-- Table --}}
                {{--
                    <livewire:data-table
                    :columns="$this->getVaccinesColumns()"
                    :data="$this->vaccinesData"
                    showCheckbox="true"
                    showActions="true"
                    enablePagination="true"
                    />
                --}}

                @break
        @endswitch
    </main>
</div>
