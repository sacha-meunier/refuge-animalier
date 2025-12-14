<x-layouts.auth>
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <x-layouts.auth.header
            title="{{ __('auth/forgot_password.title') }}"
            description="{{ __('auth/forgot_password.description') }}"
        />

        {{-- Session status --}}
        <x-layouts.auth.session-status status="{{ session('status') }}" />

        {{-- Login Form --}}
        <form
            method="POST"
            action="{{ route("password.email") }}"
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
            />

            {{-- Button --}}
            <x-button type="submit">
                {{ __("auth/forgot_password.button") }}
            </x-button>
        </form>
    </div>
</x-layouts.auth>

