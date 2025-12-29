<?php

use App\Models\Animal;
use Livewire\Component;

new class extends Component {
    public Animal $animal;
    public $name;
    public $description;

    public function mount()
    {
        $this->name = $this->animal->name;
        $this->description = $this->animal->description;
    }

    public function closeModal()
    {
        $this->dispatch('close-modal');
    }

    public function save()
    {
        $this->authorize("update", $this->animal);

        $this->animal->update([
            "name" => $this->name,
            "description" => $this->description,
        ]);

        //$this->animal->update($this->form->all());

        $this->dispatch("update-animal");
        $this->dispatch('close-modal');
    }

    public function cancel()
    {
        $this->dispatch('close-modal');
    }
};
?>

<x-modal onClose="closeModal">
    <x-modal.header
        :breadcrumb="[
            ['label' => __('pages/animals/index.title'), 'route' => 'animals.index'],
            ['label' => $animal->name]
        ]"
    />

    <x-modal.content>
        <form wire:submit.prevent="save">
            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_name") }}
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model="name"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-2">
                    {{ __("modals/animals/edit.field_description") }}
                </label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="4"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                ></textarea>
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
