<?php

use App\Livewire\Forms\AdoptionForm;
use App\Models\Adoption;
use App\Enums\AdoptionStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public Adoption $adoption;
    public AdoptionForm $form;

    public function mount(Adoption $adoption)
    {
        $this->form->setAdoption($adoption);
    }

    #[Computed]
    public function statuses()
    {
        return AdoptionStatus::cases();
    }

    public function save()
    {
        $this->authorize("update", $this->adoption);

        // Store old status value to detect changes
        $oldStatusValue = $this->adoption->status->value;

        $this->form->update();

        // Reload adoption to get updated status
        $this->adoption->refresh();

        // Check if status changed
        if ($oldStatusValue !== $this->adoption->status->value) {
            // Status changed, show notification prompt (don't close, just switch modal)
            $this->dispatch(
                "open-modal",
                modal: "notify-confirm",
                params: ["adoption" => $this->adoption->id],
            );
        } else {
            // Status didn't change, just close and refresh
            $this->dispatch("close-modal");
            $this->dispatch("refresh-adoptions");
        }
    }

    public function cancel()
    {
        $this->dispatch("close-modal");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/adoptions/index.title') }}"
        current_page="{{ $adoption->animal?->name }} x {{ $adoption->contact?->name }}"
    />

    <x-modal.content>
        <form wire:submit="save">
            {{-- Status --}}
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
        <x-button type="button" variant="ghost" size="sm" wire:click="cancel">
            {{ __("modals/modals.button_cancel") }}
        </x-button>

        <x-button type="button" variant="primary" size="sm" wire:click="save">
            {{ __("modals/modals.button_save") }}
        </x-button>
    </x-modal.footer>
</x-modal>
