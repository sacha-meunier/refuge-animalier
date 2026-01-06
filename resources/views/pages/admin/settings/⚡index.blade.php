<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public bool $receive_adoption_emails = false;

    public function mount()
    {
        $this->receive_adoption_emails =
            auth()->user()->receive_adoption_emails ?? false;
    }

    public function toggleAdoptionEmails()
    {
        $this->authorize("manageEmailNotifications", auth()->user());

        auth()->user()->update([
                "receive_adoption_emails" => $this->receive_adoption_emails,
            ]);

        session()->flash("success", __("pages/settings/index.success_message"));
    }
};
?>

<div class="w-full">
    <livewire:page-header
        title="{{ __("pages/settings/index.title") }}"
        showAction="false"
    />

    <div class="max-w-2xl mx-auto mt-8">
        <div class="bg-card border border-border rounded-lg p-6">
            <h2 class="text-lg font-semibold text-foreground mb-4">
                {{ __("pages/settings/index.email_preferences_title") }}
            </h2>

            <x-client.flash-message />

            @can("manage-email-notifications", User::class)
                <div class="space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input
                            type="checkbox"
                            wire:model="receive_adoption_emails"
                            wire:change="toggleAdoptionEmails"
                            class="mt-1 w-4 h-4 text-primary border-border rounded focus:ring-primary focus:ring-offset-0 focus:ring-2 cursor-pointer"
                        />
                        <div class="flex-1">
                            <div
                                class="text-sm font-medium text-foreground group-hover:text-primary transition-colors"
                            >
                                {{ __("pages/settings/index.receive_adoption_emails_label") }}
                            </div>
                            <div class="text-xs text-muted-foreground mt-1">
                                {{ __("pages/settings/index.receive_adoption_emails_description") }}
                            </div>
                        </div>
                    </label>
                </div>
            @else
                <p class="text-sm text-muted-foreground">
                    {{ __("pages/settings/index.no_settings_available") }}
                </p>
            @endcan
        </div>
    </div>
</div>
