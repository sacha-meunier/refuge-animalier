<?php

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Livewire\Forms\AnimalForm;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public AnimalForm $form;
    public array $genders;
    public Collection $breeds;
    public Collection $coats;
    public array $statuses;

    public function mount()
    {
        // Add default first image input
        if (empty($this->form->images)) {
            $this->form->addImageInput();
        }
    }

    public function save()
    {
        $this->authorize("create", Animal::class);
        $this->form->store();

        $this->dispatch("close-modal");
        $this->dispatch("refresh-animals");
    }

    public function addImageInput()
    {
        $this->form->addImageInput();
    }

    public function removeImageInput(int $index)
    {
        $this->form->removeImageInput($index);
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/animals/index.title') }}"
        current_page="{{ __('modals/animals/create.breadcrumb_create') }}"
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

            {{-- Images --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_images") }}
                </label>

                @foreach ($this->form->images as $index => $image)
                    <div class="flex gap-2 mb-2">
                        <input
                            type="file"
                            wire:model="form.images.{{ $index }}"
                            accept="image/jpeg,image/png,image/webp"
                            class="flex-1 px-3 py-2 border border-border rounded-md bg-background text-sm"
                        />
                        @if (count($this->form->images) > 1)
                            <button
                                type="button"
                                wire:click="removeImageInput({{ $index }})"
                                class="px-3 py-2 border border-destructive text-destructive rounded-md hover:bg-destructive/10 transition-colors text-sm font-medium"
                            >
                                {{ __("components.remove") }}
                            </button>
                        @endif
                    </div>
                    <div>
                        @error("form.images.{{ $index }}")
                            <span class="text-destructive text-xs">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                @endforeach

                <button
                    type="button"
                    wire:click="addImageInput()"
                    class="mt-2 px-3 py-2 border border-border bg-secondary rounded-md hover:bg-secondary/80 transition-colors text-sm font-medium"
                >
                    + {{ __("modals/animals/create.add_image") }}
                </button>
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
                        <span class="text-destructive">{{ $message }}</span>
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
                        <span class="text-destructive">{{ $message }}</span>
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
        <x-button type="button" variant="primary" size="sm" wire:click="save">
            {{ __("modals/modals.button_save") }}
        </x-button>
    </x-modal.footer>
</x-modal>
