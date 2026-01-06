<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public bool $receive_adoption_emails = false;
    public string $locale = "en";

    public function mount()
    {
        $this->receive_adoption_emails =
            auth()->user()->receive_adoption_emails ?? false;

        $this->locale = session("locale", config("app.locale"));
    }

    public function toggleAdoptionEmails()
    {
        $this->authorize("manageEmailNotifications", auth()->user());

        auth()->user()->update([
                "receive_adoption_emails" => $this->receive_adoption_emails,
            ]);

        session()->flash("success", __("pages/settings/index.success_message"));
    }

    public function updateLocale()
    {
        $availableLocales = implode(",", config("app.available_locales"));

        $this->validate([
            "locale" => "required|string|in:{$availableLocales}",
        ]);

        session()->put("locale", $this->locale);

        session()->flash("success", __("pages/settings/index.locale_updated"));

        $this->redirect(route("settings.index"));
    }
};
?>

<div class="w-full">
    <livewire:page-header
        title="{{ __("pages/settings/index.title") }}"
        showAction="false"
    />

    <div class="max-w-2xl mx-auto mt-8 space-y-6">
        <!-- Language Settings -->
        <div class="bg-card border border-border rounded-lg p-6">
            <h2 class="text-lg font-semibold text-foreground mb-4">
                {{ __("pages/settings/index.language_preferences_title") }}
            </h2>

            <x-client.flash-message />

            <form wire:submit="updateLocale" class="space-y-4">
                <div>
                    <label
                        for="locale"
                        class="block text-sm font-medium text-foreground mb-2"
                    >
                        {{ __("pages/settings/index.language_label") }}
                    </label>
                    <select
                        id="locale"
                        wire:model="locale"
                        class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    >
                        @php
                            $languageNames = [
                                "en" => "English",
                                "fr" => "Français",
                                "de" => "Deutsch",
                                "nl" => "Nederlands",
                            ];
                        @endphp

                        @foreach (config("app.available_locales") as $localeCode)
                            <option value="{{ $localeCode }}">
                                {{ $languageNames[$localeCode] ?? strtoupper($localeCode) }}
                                ({{ strtoupper($localeCode) }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-muted-foreground mt-1">
                        {{ __("pages/settings/index.language_description") }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors"
                >
                    {{ __("pages/settings/index.save_language") }}
                </button>
            </form>
        </div>

        <!-- Email Preferences -->
        <div class="bg-card border border-border rounded-lg p-6">
            <h2 class="text-lg font-semibold text-foreground mb-4">
                {{ __("pages/settings/index.email_preferences_title") }}
            </h2>

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
