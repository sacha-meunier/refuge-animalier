<?php

use App\Livewire\Forms\AnimalForm;
use App\Livewire\Traits\WithBulkActions;
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
    use WithPagination, WithSearch, WithSorting, WithBulkActions, WithModal;

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
};
?>

<div>
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
