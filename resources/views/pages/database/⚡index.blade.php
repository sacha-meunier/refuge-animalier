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
        if (!in_array($this->activeTab, ["species", "breeds", "vaccines"])) {
            $this->activeTab = "species";
        }
    }

    // Static data for demo
    public function getSpeciesData(): array
    {
        return [
            [
                "id" => 1,
                "name" => "Chien",
                "breeds_count" => 8,
                "created_at" => "19/11/2025",
                "avatar" => "🐕",
            ],
            [
                "id" => 2,
                "name" => "Chat",
                "breeds_count" => 5,
                "created_at" => "19/11/2025",
                "avatar" => "🐈",
            ],
        ];
    }

    // Static data for demo
    public function getBreedsData(): array
    {
        return [
            [
                "id" => 1,
                "name" => "Labrador",
                "specie" => "Chien",
                "created_at" => "19/11/2025",
                "avatar" => "🐕",
            ],
            [
                "id" => 2,
                "name" => "Berger Allemand",
                "specie" => "Chien",
                "created_at" => "19/11/2025",
                "avatar" => "🐕",
            ],
        ];
    }

    // Static data for demo
    public function getVaccinesData(): array
    {
        return [
            [
                "id" => 1,
                "name" => "Hépatite",
                "category" => "Essentiels",
                "description" => "Vaccin de base",
                "specie" => "Chien",
            ],
            [
                "id" => 2,
                "name" => "Rage",
                "category" => "Rage",
                "description" => "Obligatoire",
                "specie" => "Chien",
            ],
        ];
    }

    // Column definitions for each tab
    public function getSpeciesColumns(): array
    {
        return [
            [
                "key" => "avatar",
                "label" => "Aperçu",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "name",
                "label" => "Nom de l'espèce",
                "type" => "text"
            ],
            [
                "key" => "breeds_count",
                "label" => "Races associés",
                "type" => "text",
                "muted" => true,
            ],
            [
                "key" => "created_at",
                "label" => "Date de création",
                "type" => "text",
                "muted" => true,
            ],
        ];
    }

    public function getBreedsColumns(): array
    {
        return [
            [
                "key" => "avatar",
                "label" => "Aperçu",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "name",
                "label" => "Nom de la race",
                "type" => "text"
            ],
            [
                "key" => "specie",
                "label" => "Espèce",
                "type" => "badge"
            ],
            [
                "key" => "created_at",
                "label" => "Date de création",
                "type" => "text",
                "muted" => true,
            ],
        ];
    }

    public function getVaccinesColumns(): array
    {
        return [
            ["key" => "name", "label" => "Vaccine name", "type" => "text"],
            ["key" => "category", "label" => "Category", "type" => "badge"],
            [
                "key" => "description",
                "label" => "Description",
                "type" => "text",
            ],
            [
                "key" => "specie",
                "label" => "Related species",
                "type" => "badge",
            ],
        ];
    }

    /* Setup for Livewire pagination */
    /*#[Computed]
    public function species()
    {
        return Specie::paginate(10);
    }*/
};
?>

<div class="w-full">
    <header class="h-14 px-6 flex items-center gap-2 border-b border-border">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm">
            <span class="font-medium">
                {{ __("pages/database/index.title") }}
            </span>
            <x-svg.chevron-right class="text-muted-foreground"/>
        </div>

        {{-- Tabs Navigation --}}
        <nav class="flex items-center p-1 bg-accent rounded-xl" aria-label="Tabs">
            {{-- Species Tab --}}
            @can("view-any", Specie::class)
                <x-tab_item tabname="species" activetab="{{ $activeTab }}">
                    {{ __('pages/database/index.label_tabs_species') }}
                </x-tab_item>
            @endcan

            {{-- Breeds Tab --}}
            @can("view-any", Breed::class)
                <x-tab_item tabname="breeds" activetab="{{ $activeTab }}">
                    {{ __('pages/database/index.label_tabs_breeds') }}
                </x-tab_item>
            @endcan

            {{-- Vaccines Tab --}}
            @can("view-any", Vaccine::class)
                <x-tab_item tabname="vaccines" activetab="{{ $activeTab }}">
                    {{ __('pages/database/index.label_tabs_vaccines') }}
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
                    searchPlaceholder="{{ __('pages/database/index.label_search_species')}}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_species')}}"
                    actionPermission="create"
                    :actionModel="Specie::class"
                />

                {{-- Table --}}
                <livewire:data-table
                    :columns="$this->getSpeciesColumns()"
                    :data="$this->getSpeciesData()"
                    showCheckbox="true"
                    showActions="true"
                    enablePagination="false"
                />
                @break

            @case("breeds")
                {{-- Search and Actions Bar --}}
                <livewire:actions-bar
                    searchPlaceholder="{{ __('pages/database/index.label_search_breeds')}}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_breeds')}}"
                    actionPermission="create"
                    :actionModel="Breed::class"
                />

                {{-- Table --}}
                <livewire:data-table
                    :columns="$this->getBreedsColumns()"
                    :data="$this->getBreedsData()"
                    showCheckbox="true"
                    showActions="true"
                    enablePagination="false"
                />
                @break

            @case("vaccines")
                {{-- Search and Actions Bar --}}
                <livewire:actions-bar
                    searchPlaceholder="{{ __('pages/database/index.label_search_vaccines')}}"
                    showFilters="true"
                    showAction="true"
                    actionLabel="{{ __('pages/database/index.label_action_vaccines')}}"
                    actionPermission="create"
                    :actionModel="Specie::class"
                />

                {{-- Table --}}
                <livewire:data-table
                    :columns="$this->getVaccinesColumns()"
                    :data="$this->getVaccinesData()"
                    showCheckbox="true"
                    showActions="true"
                    enablePagination="false"
                />
                @break
        @endswitch
    </main>
</div>
