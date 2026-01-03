<?php

use App\Enums\AdoptionStatus;
use App\Livewire\Forms\AdoptionForm;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Contact;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public AdoptionForm $form;
    public Collection $animals;
    public Collection $contacts;
    public array $statuses;

    public function save()
    {
        $this->authorize("create", Adoption::class);
        $this->form->store();

        $this->dispatch("close-modal");
        $this->dispatch("refresh-adoptions");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/adoptions/index.title') }}"
        current_page="{{ __('modals/adoptions/create.breadcrumb_create') }}"
    />

    <x-modal.content>
        <form wire:submit="save">
            {{-- Contact name --}}
            @if($contacts)
                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium mb-2">
                        {{ __("modals/adoptions/create.field_contact") }}
                    </label>
                    <select
                        id="contact"
                        wire:model="form.contact_id"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/adoptions/create.select_contact") }}
                        </option>
                        @foreach ($this->contacts as $contact)
                            <option
                                value="{{ $contact->id }}"
                                wire:key="contact-{{ $contact->id }}"
                            >
                                {{ $contact->name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error("form.contact_id")
                            <span class="text-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Animal name --}}
            @if($animals)
                <div class="mb-4">
                    <label for="animal" class="block text-sm font-medium mb-2">
                        {{ __("modals/adoptions/create.field_animal") }}
                    </label>
                    <select
                        id="animal"
                        wire:model="form.animal_id"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background"
                    >
                        <option value="">
                            {{ __("modals/adoptions/create.select_animal") }}
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
                        <span class="text-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium mb-2">
                    {{ __("modals/adoptions/create.content") }}
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
            </div>

            @if ($this->statuses)
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        {{ __("modals/adoptions/edit.field_status") }}
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
