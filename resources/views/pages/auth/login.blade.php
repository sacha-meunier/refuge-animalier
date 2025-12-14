<x-layouts.auth>
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <x-layouts.auth.header
            title="{{ __('auth/login.title') }}"
            description="{{ __('auth/login.description') }}"
        />

        {{-- Session status --}}
        <x-layouts.auth.session-status status="{{ session('status') }}" />

        {{-- Login Form --}}
        <form
            method="POST"
            action="{{ route("login") }}"
            class="flex flex-col gap-6"
        >
            @csrf

            {{-- Email adress --}}
            <x-input
                type="email"
                name="email"
                label="{{ __('forms.input_email_label') }}"
                placeholder="{{ __('forms.input_email_placeholder') }}"
                required
                autocomplete="email"
            />

            {{-- Password --}}
            <div class="relative">
                <x-input
                    type="password"
                    name="password"
                    label="{{ __('forms.input_password_label') }}"
                    placeholder="{{ __('forms.input_password_placeholder') }}"
                    required
                    autocomplete="current-password"
                />
                @if (Route::has("password.request"))
                    <x-link
                        :href="route('password.request')"
                        variant="underline"
                        class="absolute top-0 end-0"
                        wire:navigate
                    >
                        {{ __("auth/login.forgot_password") }}
                    </x-link>
                @endif
            </div>

            {{-- Remember me --}}
            <x-input
                type="checkbox"
                name="remember"
                label="{{ __('forms.input_remember_label') }}"
                value="1"
            />

            {{-- Button --}}
            <x-button type="submit">
                {{ __("auth/login.button") }}
            </x-button>
        </form>
    </div>
</x-layouts.auth>
