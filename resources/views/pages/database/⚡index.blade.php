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
        <nav
            class="flex items-center p-1 bg-accent rounded-xl"
            aria-label="Tabs"
        >
            {{-- Species Tab --}}
            @can("view-any", Specie::class)
                <x-tab_item tabname="species" activetab="{{ $activeTab }}">
                    Species
                </x-tab_item>
            @endcan

            {{-- Breeds Tab --}}
            @can("view-any", Breed::class)
                <x-tab_item tabname="breeds" activetab="{{ $activeTab }}">
                    Breeds
                </x-tab_item>
            @endcan

            {{-- Vaccines Tab --}}
            @can("view-any", Vaccine::class)
                <x-tab_item tabname="vaccines" activetab="{{ $activeTab }}">
                    Vaccines
                </x-tab_item>
            @endcan
        </nav>
    </header>

    {{-- Tab Content --}}
    <main>
        @switch($activeTab)
            @case("species")
                {{-- Search and Actions Bar --}}
                <div
                    class="h-14 px-6 flex items-center justify-between border-b border-border"
                >
                    {{-- Search Input --}}
                    <livewire:search content="Search species"/>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <x-button type="button" variant="outline" size="sm">
                            Filters
                        </x-button>

                        @can("create", Specie::class)
                            <x-button type="button" variant="primary" size="sm">
                                Add a specie
                            </x-button>
                        @endcan
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full h-14 border-b border-border">
                    <thead class="h-14 border-b border-border">
                    <tr>
                        <livewire:cell
                            tag="th"
                            type="checkbox"
                            class="w-12 pl-6 pr-4"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Aperçu"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Nom de l'espèce"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Races associés"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Date de création"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content=""
                            class="w-12 pl-4 pr-1"
                        />
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                    @foreach ($this->getSpeciesData() as $specie)
                        <tr class="h-14 hover:bg-muted/30 transition-colors">
                            <livewire:cell
                                type="checkbox"
                                class="w-12 pl-6 pr-4"
                            />
                            <livewire:cell
                                type="avatar-text"
                                :avatar="$specie['avatar']"
                                :content="$specie['avatar']"
                            />
                            <livewire:cell
                                type="text"
                                :content="$specie['name']"
                            />
                            <livewire:cell
                                type="text"
                                :content="$specie['breeds_count'] . ' races'"
                                :muted="true"
                            />
                            <livewire:cell
                                type="text"
                                :content="$specie['created_at']"
                                :muted="true"
                            />
                            <livewire:cell type="button"/>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{--{{ $this->species->links() }}--}}
                @break
            @case("breeds")
                {{-- Search and Actions Bar --}}
                <div
                    class="h-14 px-6 flex items-center justify-between border-b border-border"
                >
                    {{-- Search Input --}}
                    <livewire:search content="Search breeds"/>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <x-button type="button" variant="outline" size="sm">
                            Filters
                        </x-button>

                        @can("create", Breed::class)
                            <x-button type="button" variant="primary" size="sm">
                                Add a breed
                            </x-button>
                        @endcan
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full h-14 border-b border-border">
                    <thead class="h-14 border-b border-border">
                    <tr>
                        <livewire:cell
                            tag="th"
                            type="checkbox"
                            class="w-12 pl-6 pr-4"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Aperçu"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Nom de l'espèce"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Races associés"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Date de création"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content=""
                            class="w-12 pl-4 pr-1"
                        />
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                    @foreach ($this->getBreedsData() as $breed)
                        <tr class="h-14 hover:bg-muted/30 transition-colors">
                            <livewire:cell
                                type="checkbox"
                                class="w-12 pl-6 pr-4"
                            />
                            <livewire:cell
                                type="avatar-text"
                                :avatar="$breed['avatar']"
                                :content="$breed['avatar']"
                            />
                            <livewire:cell
                                type="text"
                                :content="$breed['name']"
                            />
                            <livewire:cell
                                type="badge"
                                :content="$breed['specie']"
                            />
                            <livewire:cell
                                type="text"
                                :content="$breed['created_at']"
                                :muted="true"
                            />
                            <livewire:cell type="button"/>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{--{{ $this->breeds->links() }}--}}

                @break
            @case("vaccines")
                {{-- Search and Actions Bar --}}
                <div
                    class="h-14 px-6 flex items-center justify-between border-b border-border"
                >
                    {{-- Search Input --}}
                    <livewire:search content="Search vaccines"/>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <x-button type="button" variant="outline" size="sm">
                            Filters
                        </x-button>

                        @can("create", Vaccine::class)
                            <x-button type="button" variant="primary" size="sm">
                                Add a vaccine
                            </x-button>
                        @endcan
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full h-14 border-b border-border">
                    <thead class="h-14 border-b border-border">
                    <tr>
                        <livewire:cell
                            tag="th"
                            type="checkbox"
                            class="w-12 pl-6 pr-4"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Vaccine name"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Category"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Description"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content="Related species"
                        />
                        <livewire:cell
                            tag="th"
                            type="text"
                            content=""
                            class="w-12 pl-4 pr-1"
                        />
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                    @foreach ($this->getVaccinesData() as $vaccine)
                        <tr class="h-14 hover:bg-muted/30 transition-colors">
                            <livewire:cell
                                type="checkbox"
                                class="w-12 pl-6 pr-4"
                            />
                            <livewire:cell
                                type="text"
                                :content="$vaccine['name']"
                            />
                            <livewire:cell
                                type="badge"
                                :content="$vaccine['category']"
                            />
                            <livewire:cell
                                type="text"
                                :content="$vaccine['description']"
                            />
                            <livewire:cell
                                type="badge"
                                :content="$vaccine['specie']"
                            />
                            <livewire:cell type="button"/>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{--{{ $this->vaccines->links() }}--}}
                @break
        @endswitch
    </main>
</div>
