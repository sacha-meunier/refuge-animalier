<x-layouts.auth>
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <x-layouts.auth.header
            title="{{ __('auth/login.title') }}"
            description="{{ __('auth/login.description') }}"
        />

        {{-- Session status --}}
        <x-layouts.auth.session-status status="{{ session('status') }}"/>

        {{-- Login Form --}}
        <form
            method="POST"
            action="{{ route("password.update") }}"
            class="flex flex-col gap-6"
        >
            @csrf
            {{-- Token --}}
            <x-input
                type="hidden"
                name="token"
                value="{{ request()->route('token') }}"
            />

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
            <x-input
                type="password"
                name="password"
                label="{{ __('forms.input_password_label') }}"
                placeholder="{{ __('forms.input_password_placeholder') }}"
                required
            />

            {{-- Password confirmation --}}
            <x-input
                type="password"
                name="password_confirmation"
                label="{{ __('forms.input_password_confirmation_label') }}"
                placeholder="{{ __('forms.input_password_confirmation_placeholder') }}"
                required
            />

            {{-- Button --}}
            <x-button type="submit">
                {{ __("auth/reset_password.button") }}
            </x-button>
        </form>
    </div>
</x-layouts.auth>

