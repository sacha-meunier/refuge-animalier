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

    #[Computed]
    public function animals()
    {
        return Animal::paginate($this->paginate);
    }

    #[On("open-create-modal")]
    public function createAnimal()
    {
        $this->selectedAnimalId = null;
        $this->modalMode = "create";
    }

    #[On("refresh-animals")]
    public function refreshAnimals()
    {
        $this->resetPage();
        $this->closeModal();
    }

    #[On("close-modal")]
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

    #[On("delete-animal")]
    public function deleteAnimal(int $animalId)
    {
        $animal = Animal::findOrFail($animalId);
        $this->authorize("delete", $animal);

        $this->form->delete($animal);

        $this->closeModal();
        unset($this->animals);
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->selectedAnimalId = null;
        $this->modalMode = null;
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
        <tr>
            <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

            <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_animal_name') }}"/>

            <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_age') }}"/>

            <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_gender') }}"/>

            <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_status') }}"/>

            <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_admission_date') }}"/>

            <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
        </tr>
        </thead>
        <tbody>
            @forelse ($this->animals as $animal)
                <tr
                    class="h-14 hover:bg-muted/50 cursor-pointer"
                    wire:key="animal-row-{{ $animal->id }}-{{ $animal->updated_at->timestamp }}"
                    wire:click="showAnimal({{ $animal->id }})"
                >
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

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

                    <livewire:cell type="button" />
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

    <div class="h-14 px-6 flex align-center">
        {{ $this->animals->links() }}
    </div>

    @if ($selectedAnimalId && $this->selectedAnimal && $modalMode === "show")
        <livewire:modal.animal-show
            :animal="$this->selectedAnimal"
            :key="'animal-show-'.$selectedAnimalId"
        />
    @endif

    @if ($this->selectedAnimal && $modalMode === "edit")
        <livewire:modal.animal-edit
            :animal="$this->selectedAnimal"
            :key="'animal-edit-'.$this->selectedAnimal->id"
        />

    @if ($modalMode === "create")
        <livewire:modal.animal-create :key="'animal-create'" />
    @endif
</div>
