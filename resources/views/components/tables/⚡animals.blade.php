<?php

use App\Livewire\Forms\AnimalForm;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public AnimalForm $form;

    public int $paginate = 10;
    public ?int $selectedAnimalId = null;
    public ?string $modalMode = "";
    public array $selectedIds = [];
    public bool $selectAll = false;

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
        return Animal::paginate($this->paginate);
    }

    #[On('open-create-modal')]
    public function createAnimal()
    {
        $this->selectedAnimalId = null;
        $this->modalMode = "create";
    }

    #[On('refresh-animals')]
    public function refreshAnimals()
    {
        unset($this->animals);
        $this->closeModal();
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->selectedAnimalId = null;
        $this->modalMode = null;
    }

    #[Computed]
    public function selectedAnimal()
    {
        return $this->selectedAnimalId
            ? Animal::find($this->selectedAnimalId)
            : null;
    }

    public function showAnimal(int $animalId)
    {
        $this->selectedAnimalId = $animalId;
        $this->modalMode = "show";
    }

    #[On('switch-to-edit-mode')]
    public function editAnimal(?int $animalId = null)
    {
        if ($animalId) {
            $this->selectedAnimalId = $animalId;
        }
        $this->modalMode = "edit";
    }

    #[On('delete-animal')]
    public function deleteAnimal(int $animalId)
    {
        $animal = Animal::findOrFail($animalId);
        $this->authorize('delete', $animal);

        $this->form->delete($animal);

        $this->closeModal();
        unset($this->animals);
    }

    public function deleteSelected()
    {
        foreach ($this->selectedIds as $id) {
            $animal = Animal::findOrFail($id);
            $this->authorize('delete', $animal);
            $this->form->delete($animal);
        }

        $this->selectedIds = [];
        $this->selectAll = false;
        unset($this->animals);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->animals->pluck("id")->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    #[On('update-animal')]
    public function handleUpdate($animalId)
    {
        unset($this->animals);
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
                <th
                    class="w-12 pl-6 pr-4 text-left text-xs font-medium text-muted-foreground tracking-wider"
                >
                    <input
                        type="checkbox"
                        class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer hover:ring-2 hover:ring-primary/50 transition-all"
                        wire:model.live="selectAll"
                        @mouseenter="hoverAll = true"
                        @mouseleave="hoverAll = false"
                    />
                </th>

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/animals/index.th_animal_name') }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/animals/index.th_age') }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/animals/index.th_gender') }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/animals/index.th_status') }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/animals/index.th_admission_date') }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content=""
                    class="w-12 pl-4 pr-1"
                />
            </tr>
        </thead>
        <tbody>
            @forelse ($this->animals as $animal)
                <tr
                    class="h-14 hover:bg-muted/50 cursor-pointer"
                    wire:key="animal-row-{{ $animal->id }}-{{ $animal->updated_at->timestamp }}"
                    wire:click="showAnimal({{ $animal->id }})"
                >
                    <td class="w-12 pl-6 pr-4" wire:click.stop>
                        <input
                            type="checkbox"
                            class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer transition-all"
                            :class="hoverAll ? 'ring-2 ring-primary/50' : 'hover:ring-2 hover:ring-primary/50'"
                            value="{{ $animal->id }}"
                            wire:model.live="selectedIds"
                        />
                    </td>

                    <livewire:cell type="text" content="{{ $animal->name }}" />

                    <livewire:cell
                        type="text"
                        content="{{ $animal->formatted_age ?? __('dates.not_available') }}"
                    />

                    <livewire:cell
                        type="text"
                        content="{{ $animal->gender?->label() ?? __('dates.not_available') }}"
                    />

                    <livewire:cell
                        type="badge"
                        content="{{ $animal->status?->label() ?? __('dates.not_available') }}"
                        badge-color="{{ $animal->status?->color() ?? '' }}"
                    />

                    <livewire:cell
                        type="text"
                        content="{{ $animal->formatted_admission_date ?? __('dates.not_available') }}"
                    />

                    <livewire:cell type="button" wire:click.stop />
                </tr>
            @empty
                <tr>
                    <td class="h-32 text-center text-sm text-muted-foreground">
                        {{ __('pagination.no_data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 gap-6 flex align-center">
        @if (count($selectedIds) > 0)
            <div class="flex items-center gap-4">
                <p class="text-sm text-muted-foreground whitespace-nowrap">
                    {{ count($selectedIds) }}
                    {{ count($selectedIds) === 1 ? __('pagination.selected_singular') : __('pagination.selected_plural') }}
                </p>
                <x-button
                    variant="destructive"
                    size="sm"
                    wire:click="deleteSelected"
                    wire:confirm="{{ __('modals/modals.confirm_delete_multiple') }}"
                >
                    {{ __('modals/modals.button_delete') }}
                </x-button>
            </div>
        @endif

        {{ $this->animals->links() }}
    </div>

    @if ($selectedAnimalId && $this->selectedAnimal && $modalMode === "show")
        <livewire:modal.animal-show
            :animal="$this->selectedAnimal"
            :key="'animal-show-'.$selectedAnimalId"
        />
    @endif

    @if ($selectedAnimalId && $this->selectedAnimal && $modalMode === "edit")
        <livewire:modal.animal-edit
            :animal="$this->selectedAnimal"
            :genders="$this->genders"
            :breeds="$this->breeds"
            :coats="$this->coats"
            :statuses="$this->statuses"
            :key="'animal-edit-'.$selectedAnimalId"
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
