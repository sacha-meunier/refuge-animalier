<?php

use App\Models\Specie;
use App\Models\Breed;
use App\Models\Vaccine;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component {
    #[Url(as: "tab")]
    public string $activeTab = "species";

    public function mount(): void
    {
        // Ensure activeTab is valid
        if (!in_array($this->activeTab, ["species", "breeds", "vaccines"])) {
            $this->activeTab = "species";
        }
    }
};
?>

<div>
    <h1 class="text-2xl font-bold mb-6">
        {{ __("pages/database/index.title") }}
    </h1>

    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            {{-- Species Tab --}}
            @can('view-any', Specie::class)
                <button
                    wire:click="$set('activeTab', 'species')"
                    {{-- @if($activeTab === 'species') --}}
                    class=""
                >
                    Species
                </button>
            @endcan

            {{-- Breeds Tab --}}
            @can('view-any', Breed::class)
                <button
                    wire:click="$set('activeTab', 'breeds')"
                    {{-- @if($activeTab === 'species') --}}
                    class=""
                >
                    Breeds
                </button>
            @endcan

            {{-- Vaccines Tab --}}
            @can('view-any', Vaccine::class)
                <button
                    wire:click="$set('activeTab', 'vaccines')"
                    {{-- @if($activeTab === 'species') --}}
                    class=""
                >
                    Vaccines
                </button>
            @endcan
        </nav>
    </div>

    {{-- Tab Content --}}
    <div>
        @switch($activeTab)
            @case("species")
                <div>Species</div>
                @break

            @case("breeds")
                <div>Breeds</div>
                @break

            @case("vaccines")
                <div>Vaccines</div>
                @break
        @endswitch
    </div>
</div>
