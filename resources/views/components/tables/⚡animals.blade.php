<?php

use App\Livewire\Forms\AnimalForm;
use App\Livewire\Traits\WithBulkActions;
use App\Livewire\Traits\WithFilters;
use App\Livewire\Traits\WithModal;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination,
        WithSearch,
        WithSorting,
        WithBulkActions,
        WithModal,
        WithFilters;

    public AnimalForm $form;
    public int $paginate = 10;

    protected function getModelClass(): string
    {
        return Animal::class;
    }

    protected function getItems()
    {
        return $this->animals;
    }

    protected function resetItems(): void
    {
        unset($this->animals);
    }

    #[Computed(persist: true)]
    public function genders()
    {
        return AnimalGender::cases();
    }

    #[Computed(persist: true)]
    public function breeds()
    {
        return Breed::all();
    }

    #[Computed(persist: true)]
    public function coats()
    {
        return Coat::all();
    }

    #[Computed(persist: true)]
    public function statuses()
    {
        return AnimalStatus::cases();
    }

    #[Computed]
    public function genderCounts()
    {
        $counts = Animal::query()
            ->selectRaw("gender, COUNT(*) as count")
            ->groupBy("gender")
            ->pluck("count", "gender");

        return collect(AnimalGender::cases())->mapWithKeys(function (
            $gender,
        ) use ($counts) {
            return [$gender->value => $counts[$gender->value] ?? 0];
        });
    }

    #[Computed]
    public function statusCounts()
    {
        $counts = Animal::query()
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy("status")
            ->pluck("count", "status");

        return collect(AnimalStatus::cases())->mapWithKeys(function (
            $status,
        ) use ($counts) {
            return [$status->value => $counts[$status->value] ?? 0];
        });
    }

    #[Computed]
    public function animals()
    {
        return Animal::query()
            ->when($this->search, function ($query) {
                $query
                    ->where("name", "like", "%" . $this->search . "%")
                    ->orWhere("description", "like", "%" . $this->search . "%")
                    ->orWhereHas("breed", function ($q) {
                        $q->where("name", "like", "%" . $this->search . "%");
                    })
                    ->orWhereHas("coat", function ($q) {
                        $q->where("name", "like", "%" . $this->search . "%");
                    });
            })
            ->when($this->getFilterValue("gender"), function ($query, $gender) {
                $query->where("gender", $gender);
            })
            ->when($this->getFilterValue("status"), function ($query, $status) {
                $query->where("status", $status);
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->paginate);
    }

    #[On("refresh-animals")]
    public function refreshAnimals()
    {
        $this->resetItems();
        $this->closeModal();
    }

    #[On("delete-animal")]
    public function deleteAnimal(int $animalId)
    {
        $animal = Animal::findOrFail($animalId);
        $this->authorize("delete", $animal);

        $this->form->delete($animal);

        $this->closeModal();
        unset($this->animals);
    }
};
?>

<div>
    <x-filters-popover>
        <div class="space-y-4">
            {{-- Gender Filter --}}
            <div class="space-y-2">
                <label
                    for="genderFilter"
                    class="block text-sm font-medium text-foreground"
                >
                    {{ __("pages/animals/index.th_gender") }}
                </label>
                <select
                    id="genderFilter"
                    wire:model.live="filters.gender"
                    wire:change="closeFilters"
                    class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                >
                    <option value="">{{ __("components.all") }}</option>
                    @foreach ($this->genders as $gender)
                        <option value="{{ $gender->value }}">
                            {{ $gender->label() }}
                            ({{ $this->genderCounts[$gender->value] }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="space-y-2">
                <label
                    for="statusFilter"
                    class="block text-sm font-medium text-foreground"
                >
                    {{ __("pages/animals/index.th_status") }}
                </label>
                <select
                    id="statusFilter"
                    wire:model.live="filters.status"
                    wire:change="closeFilters"
                    class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                >
                    <option value="">{{ __("components.all") }}</option>
                    @foreach ($this->statuses as $status)
                        <option value="{{ $status->value }}">
                            {{ $status->label() }}
                            ({{ $this->statusCounts[$status->value] }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Filters Button --}}
            @if ($this->hasActiveFilters())
                <div class="pt-2">
                    <x-button
                        type="button"
                        variant="outline"
                        size="sm"
                        wire:click="resetFilters"
                        class="w-full"
                    >
                        {{ __("components.reset_filters") }}
                    </x-button>
                </div>
            @endif
        </div>
    </x-filters-popover>

    <table
        class="w-full h-14 border-b border-border"
        x-data="{ hoverAll: false }"
    >
        <thead class="h-14 border-b border-border">
            <tr>
                <x-table.checkbox-header />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_animal_name')"
                    :sortable="true"
                    sort-field="name"
                    :sort-direction="$sortField === 'name' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_age')"
                    :sortable="true"
                    sort-field="age"
                    :sort-direction="$sortField === 'age' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_gender')"
                    :sortable="true"
                    sort-field="gender"
                    :sort-direction="$sortField === 'gender' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_status')"
                    :sortable="true"
                    sort-field="status"
                    :sort-direction="$sortField === 'status' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_publish')"
                    :sortable="true"
                    sort-field="published"
                    :sort-direction="$sortField === 'published' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/animals/index.th_admission_date')"
                    :sortable="true"
                    sort-field="admission_date"
                    :sort-direction="$sortField === 'admission_date' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    content=""
                    class="w-12 pl-4 pr-1"
                />
            </tr>
        </thead>
        <tbody>
            @forelse ($this->animals as $animal)
                <x-table.row :item="$animal">
                    <x-table.checkbox-cell :value="$animal->id" />

                    <x-cell type="text" :content="$animal->name" />

                    <x-cell
                        type="text"
                        :content="$animal->formatted_age ?? __('dates.not_available')"
                    />

                    <x-cell
                        type="text"
                        :content="$animal->gender?->label() ?? __('dates.not_available')"
                    />

                    <x-cell
                        type="badge"
                        :content="$animal->status?->label() ?? __('dates.not_available')"
                        :badge-color="$animal->status?->color() ?? ''"
                    />

                    <x-cell
                        type="badge"
                        :content="$animal->published ? __('pages/animals/index.th_publish_true') : __('pages/animals/index.th_publish_false')"
                        :badge-color="$animal->published ? 'bg-badge-success text-badge-success-foreground' : 'bg-badge-neutral text-badge-neutral-foreground'"
                    />

                    <x-cell
                        type="text"
                        :content="$animal->formatted_admission_date ?? __('dates.not_available')"
                    />

                    <x-table.actions
                        :item="$animal"
                        :selectedIds="$selectedIds"
                    />
                </x-table.row>
            @empty
                <x-table.empty />
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 gap-6 flex align-center">
        {{ $this->animals->links() }}
    </div>

    @if ($selectedItemId && $this->selectedItem && $modalMode === "show")
        <livewire:modal.animal-show
            :animal="$this->selectedItem"
            :key="'animal-show-'.$selectedItemId"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "edit")
        <livewire:modal.animal-edit
            :animal="$this->selectedItem"
            :genders="$this->genders"
            :breeds="$this->breeds"
            :coats="$this->coats"
            :statuses="$this->statuses"
            :key="'animal-edit-'.$selectedItemId"
        />
    @endif

    @if ($modalMode === "create")
        <livewire:modal.animal-create
            :genders="$this->genders"
            :breeds="$this->breeds"
            :coats="$this->coats"
            :statuses="$this->statuses"
            :key="'animal-create'"
        />
    @endif
</div>
