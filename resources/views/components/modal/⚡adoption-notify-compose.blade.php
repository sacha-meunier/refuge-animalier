<?php

use App\Mail\AdoptionStatusUpdated;
use App\Models\Adoption;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

new class extends Component {
    public Adoption $adoption;
    public string $emailContent = "";

    public function mount(Adoption $adoption)
    {
        $this->adoption = $adoption->load(["contact", "animal"]);

        // Default email content suggestion
        $this->emailContent = __("modals/adoptions/notify.default_message", [
            "name" => $this->adoption->contact->name,
            "animal" => $this->adoption->animal->name,
            "status" => $this->adoption->status->label(),
        ]);
    }

    public function sendNotification()
    {
        $this->validate(
            [
                "emailContent" => "required|string|min:10|max:5000",
            ],
            [
                "emailContent.required" => __(
                    "modals/adoptions/notify.validation_required",
                ),
                "emailContent.min" => __(
                    "modals/adoptions/notify.validation_min",
                ),
                "emailContent.max" => __(
                    "modals/adoptions/notify.validation_max",
                ),
            ],
        );

        Mail::to($this->adoption->contact)->send(
            new AdoptionStatusUpdated($this->adoption, $this->emailContent),
        );

        $this->dispatch("close-modal");
        $this->dispatch("refresh-adoptions");

        session()->flash(
            "success",
            __("modals/adoptions/notify.success_message"),
        );
    }

    public function cancel()
    {
        $this->dispatch("close-modal");
        $this->dispatch("refresh-adoptions");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/adoptions/index.title') }}"
        current_page="{{ __('modals/adoptions/notify.compose_title') }}"
    />

    <x-modal.content>
        <form wire:submit="sendNotification">
            <div class="space-y-4">
                {{-- Recipient Info --}}
                <div class="bg-muted p-4 rounded-lg space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-muted-foreground">
                            {{ __("modals/adoptions/notify.recipient") }}
                        </span>
                        <span class="text-sm text-foreground">
                            {{ $adoption->contact->name }}
                            ({{ $adoption->contact->email }})
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-muted-foreground">
                            {{ __("modals/adoptions/notify.animal") }}
                        </span>
                        <span class="text-sm text-foreground">
                            {{ $adoption->animal->name }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-muted-foreground">
                            {{ __("modals/adoptions/notify.status") }}
                        </span>
                        <x-badge :color="$adoption->status->color()">
                            {{ $adoption->status->label() }}
                        </x-badge>
                    </div>
                </div>

                {{-- Email Content --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        {{ __("modals/adoptions/notify.email_content_label") }}
                    </label>
                    <textarea
                        wire:model="emailContent"
                        rows="10"
                        class="w-full px-3 py-2 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-background text-foreground"
                        placeholder="{{ __("modals/adoptions/notify.email_content_placeholder") }}"
                    ></textarea>
                    @error("emailContent")
                        <span class="text-destructive text-sm mt-1">
                            {{ $message }}
                        </span>
                    @enderror

                    <p class="text-xs text-muted-foreground mt-1">
                        {{ __("modals/adoptions/notify.email_content_hint") }}
                    </p>
                </div>
            </div>
        </form>
    </x-modal.content>

    <x-modal.footer>
        <x-button type="button" variant="ghost" size="sm" wire:click="cancel">
            {{ __("modals/modals.button_cancel") }}
        </x-button>

        <x-button
            type="button"
            variant="primary"
            size="sm"
            wire:click="sendNotification"
        >
            {{ __("modals/adoptions/notify.button_send") }}
        </x-button>
    </x-modal.footer>
</x-modal>
