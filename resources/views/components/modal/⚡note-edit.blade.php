<?php

use App\Livewire\Forms\AnimalForm;
use App\Livewire\Forms\NoteForm;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Models\Note;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public Note $note;
    public NoteForm $form;
    public Collection $animals;

    public function mount(Note $note)
    {
        $this->form->setNote($note);
    }

    public function save()
    {
        $this->authorize('update', $this->note);
        $this->form->update();

        $this->dispatch('close-modal');
        $this->dispatch('refresh-notes');
    }

    public function cancel()
    {
        $this->dispatch('close-modal');
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/notes/index.title') }}"
        current_page="{{ $note->title }}"
    />

    <x-modal.content>
        <form wire:submit="save">
            {{-- Animal Name --}}
            @if ($this->animals)
                <div class="mb-4">
                    <label for="animal" class="block text-sm font-medium mb-2">
                        {{ __("modals/notes/create.field_animal_name") }}
                    </label>
                    <select
                        id="animal"
                        wire:model="form.animal_id"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/notes/create.select_animal") }}
                        </option>
                        @foreach ($this->animals as $animal)
                            <option
                                value="{{ $animal->id }}"
                                wire:key="animal-{{ $animal->id }}"
                            >
                                {{ $animal->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error("form.animal_id")
                        <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-2">
                    {{ __("modals/notes/create.field_note_title") }}
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="form.title"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.title")
                    <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Post Content --}}
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium mb-2">
                    {{ __("modals/notes/create.field_note_content") }}
                </label>
                <textarea
                    id="content"
                    wire:model="form.content"
                    rows="4"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                ></textarea>
                <div>
                    @error("form.content")
                    <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    @error("form.user_id")
                    <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>
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
