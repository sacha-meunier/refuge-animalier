<?php

use App\Livewire\Forms\AnimalForm;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public Animal $animal;
    public AnimalForm $form;
    public array $genders;
    public Collection $breeds;
    public Collection $coats;
    public array $statuses;

    public function mount(Animal $animal)
    {
        $this->form->setAnimal($animal);
    }

    public function save()
    {
        $this->authorize('update', $this->animal);
        $this->form->update();

        $this->dispatch('close-modal');
        $this->dispatch('refresh-animals');
    }

    public function cancel()
    {
        $this->dispatch('close-modal');
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/animals/index.title') }}"
        current_page="{{ $animal->name }}"
    />

    <x-modal.content>
        <form wire:submit="save">
            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_name") }}
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model="form.name"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.name")
                        <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_description") }}
                </label>
                <textarea
                    id="description"
                    wire:model="form.description"
                    rows="4"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                ></textarea>
                <div>
                    @error("form.description")
                        <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_image") }}
                </label>
                <input
                    type="file"
                    id="image"
                    wire:model="form.image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.image")
                    <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Gender --}}
            @if ($this->genders)
                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium mb-2">
                        {{ __("modals/animals/edit.field_gender") }}
                    </label>
                    <select
                        id="gender"
                        wire:model="form.gender"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/animals/create.select_gender") }}
                        </option>
                        @foreach ($this->genders as $gender)
                            <option
                                value="{{ $gender->value }}"
                                wire:key="gender-{{ $gender->value }}"
                            >
                                {{ $gender->label() }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error("form.gender")
                            <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Breed --}}
            @if ($this->breeds)
                <div class="mb-4">
                    <label for="breed" class="block text-sm font-medium mb-2">
                        {{ __("modals/animals/edit.field_breed") }}
                    </label>
                    <select
                        id="breed"
                        wire:model="form.breed_id"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/animals/create.select_breed") }}
                        </option>
                        @foreach ($this->breeds as $breed)
                            <option
                                value="{{ $breed->id }}"
                                wire:key="breed-{{ $breed->id }}"
                            >
                                {{ $breed->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error("form.breed_id")
                            <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Age --}}
            <div class="mb-4">
                <label for="age" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_age") }}
                </label>
                <input
                    type="date"
                    id="age"
                    wire:model="form.age"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.age")
                        <span class="text-destructive">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Coat --}}
            @if ($this->coats)
                <div class="mb-4">
                    <label for="coat" class="block text-sm font-medium mb-2">
                        {{ __("modals/animals/edit.field_coat") }}
                    </label>
                    <select
                        id="coat"
                        wire:model="form.coat_id"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/animals/create.select_coat") }}
                        </option>
                        @foreach ($this->coats as $coat)
                            <option
                                value="{{ $coat->id }}"
                                wire:key="coat-{{ $coat->id }}"
                            >
                                {{ $coat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error("form.coat_id")
                            <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Admission Date --}}
            <div class="mb-4">
                <label
                    for="admission_date"
                    class="block text-sm font-medium mb-2"
                >
                    {{ __("modals/animals/edit.field_admission_date") }}
                </label>
                <input
                    type="date"
                    id="admission_date"
                    wire:model="form.admission_date"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.admission_date")
                        <span class="text-destructive">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            @if ($this->statuses)
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        {{ __("modals/animals/edit.field_status") }}
                    </label>
                    <div class="flex flex-col gap-2">
                        @foreach ($this->statuses as $status)
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                                wire:key="status-{{ $status->value }}"
                            >
                                <input
                                    type="radio"
                                    name="status"
                                    value="{{ $status->value }}"
                                    wire:model="form.status"
                                    class="w-4 h-4 text-primary border-border focus:ring-primary"
                                />
                                <x-badge :color="$status->color() ?? ''">
                                    {{ $status->label() }}
                                </x-badge>
                            </label>
                        @endforeach
                    </div>
                    <div>
                        @error("form.status")
                            <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif
        </form>
    </x-modal.content>

    <x-modal.footer>
        <x-button type="button" variant="ghost" size="sm" wire:click="cancel">
            {{ __("modals/modals.button_cancel") }}
        </x-button>

        <x-button type="button" variant="primary" size="sm" wire:click="save">
            {{ __("modals/modals.button_save") }}
        </x-button>
    </x-modal.footer>
</x-modal>
