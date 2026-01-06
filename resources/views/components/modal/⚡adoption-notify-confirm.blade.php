<?php

use App\Models\Adoption;
use Livewire\Component;

new class extends Component {
    public Adoption $adoption;

    public function notifyContact()
    {
        $this->dispatch(
            "open-modal",
            modal: "notify-compose",
            params: ["adoption" => $this->adoption->id],
        );
    }

    public function skipNotification()
    {
        $this->dispatch("close-modal");
        $this->dispatch("refresh-adoptions");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/adoptions/index.title') }}"
        current_page="{{ __('modals/adoptions/notify.title') }}"
    />

    <x-modal.content>
        <div class="space-y-4">
            <p class="text-foreground">
                {{ __("modals/adoptions/notify.confirm_message", ["name" => $adoption->contact->name]) }}
            </p>

            <div class="bg-muted p-4 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-muted-foreground">
                        {{ __("modals/adoptions/notify.current_status") }}
                    </span>
                    <x-badge :color="$adoption->status->color()">
                        {{ $adoption->status->label() }}
                    </x-badge>
                </div>
            </div>
        </div>
    </x-modal.content>

    <x-modal.footer>
        <x-button
            type="button"
            variant="ghost"
            size="sm"
            wire:click="skipNotification"
        >
            {{ __("modals/adoptions/notify.button_no") }}
        </x-button>

        <x-button
            type="button"
            variant="primary"
            size="sm"
            wire:click="notifyContact"
        >
            {{ __("modals/adoptions/notify.button_yes") }}
        </x-button>
    </x-modal.footer>
</x-modal>
