@props([
    'type' => 'text',
    'name',
    'id' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'value' => null,
    'autocomplete' => 'off',
    'spellcheck' => 'false',
])

@php
    // Generate ID from name if not provided
    $inputId = $id ?? 'input-' . str_replace(['[', ']', '.'], ['-', '', '-'], $name);

    // Get error message from validation errors
    $hasError = $errors->has($name);
    $errorMessage = $hasError ? $errors->first($name) : null;

    // Base transition class
    $baseClasses = 'transition-colors duration-150';
@endphp

@switch($type)
    {{-- Hidden input - rendered separately, no wrapper --}}
    @case('hidden')
        <input
            type="hidden"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ $value }}"
            {{ $attributes }}
        >
        @break

        {{-- Checkbox input --}}
    @case('checkbox')
        <div class="space-y-1.5">
            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                <input
                    type="checkbox"
                    name="{{ $name }}"
                    id="{{ $inputId }}"
                    value="{{ $value }}"
                    class="{{ $baseClasses }} size-4 rounded border border-input text-primary focus:ring-2 focus:ring-ring focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($required) required @endif
                    @if($disabled) disabled @endif
                    {{ $attributes->except(['class']) }}
                >

                @if($label)
                    <label
                        for="{{ $inputId }}"
                        class="text-sm font-medium text-foreground cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                    >
                        {{ $label }}
                    </label>
                @endif
            </div>

            @if($hasError)
                <p
                    class="text-sm text-destructive"
                    id="{{ $inputId }}-error"
                    role="alert"
                >
                    {{ $errorMessage }}
                </p>
            @endif
        </div>
        @break

        {{-- Radio input --}}
    @case('radio')
        <div class="space-y-1.5">
            <div class="flex items-center gap-1.5 cursor-pointer select-none">
                <input
                    type="radio"
                    name="{{ $name }}"
                    id="{{ $inputId }}"
                    value="{{ $value }}"
                    class="{{ $baseClasses }} size-4 rounded-full border border-input text-primary focus:ring-2 focus:ring-ring focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($required) required @endif
                    @if($disabled) disabled @endif
                    {{ $attributes->except(['class']) }}
                >

                @if($label)
                    <label
                        for="{{ $inputId }}"
                        class="text-sm font-medium text-foreground cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                    >
                        {{ $label }}
                    </label>
                @endif
            </div>

            @if($hasError)
                <p
                    class="text-sm text-destructive"
                    id="{{ $inputId }}-error"
                    role="alert"
                >
                    {{ $errorMessage }}
                </p>
            @endif
        </div>
        @break

        {{-- File input --}}
    @case('file')
        <div class="space-y-1.5">
            @if($label)
                <label
                    for="{{ $inputId }}"
                    class="text-sm font-medium text-foreground {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                >
                    {{ $label }}
                    @if($required)
                        <span class="text-destructive" aria-label="required">*</span>
                    @endif
                </label>
            @endif

            <input
                type="file"
                name="{{ $name }}"
                id="{{ $inputId }}"
                class="{{ $baseClasses }} block w-full text-sm text-foreground file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-secondary file:text-secondary-foreground file:cursor-pointer hover:file:bg-secondary/80 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                @if($required) required @endif
                @if($disabled) disabled @endif
                {{ $attributes->except(['class']) }}
            >

            @if($hasError)
                <p
                    class="text-sm text-destructive"
                    id="{{ $inputId }}-error"
                    role="alert"
                >
                    {{ $errorMessage }}
                </p>
            @endif
        </div>
        @break

        {{-- Password input with visibility toggle --}}
    @case('password')
        <div class="grid gap-2">
            @if($label)
                <label
                    for="{{ $inputId }}"
                    class="text-sm font-medium text-foreground {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                >
                    {{ $label }}
                    @if($required)
                        <span class="text-destructive" aria-label="required">*</span>
                    @endif
                </label>
            @endif

            <div
                x-data="{ showPassword: false }"
                class="relative"
            >
                <input
                    :type="showPassword ? 'text' : 'password'"
                    name="{{ $name }}"
                    id="{{ $inputId }}"
                    @if($placeholder) placeholder="{{ $placeholder }}" @endif
                    value="{{ old($name, $value) }}"
                    class="{{ $baseClasses }} w-full px-3 py-2 pr-10 text-foreground bg-background border {{ $hasError ? 'border-destructive' : 'border-input' }} rounded-lg focus:outline-none focus:ring-2 {{ $hasError ? 'focus:ring-destructive' : 'focus:ring-ring' }} focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed placeholder:text-muted-foreground"
                    autocomplete="{{ $autocomplete }}"
                    spellcheck="{{ $spellcheck }}"
                    @if($required) required @endif
                    @if($disabled) disabled @endif
                    @if($readonly) readonly @endif
                    {{ $attributes->except(['class']) }}
                >

                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors select-none"
                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                    tabindex="-1"
                >
                    <span x-show="!showPassword" class="block">
                        <x-svg.eye-close/>
                    </span>
                    <span x-show="showPassword" x-cloak class="block">
                        <x-svg.eye-open/>
                    </span>
                </button>
            </div>

            @if($hasError)
                <p
                    class="text-sm text-destructive"
                    id="{{ $inputId }}-error"
                    role="alert"
                >
                    {{ $errorMessage }}
                </p>
            @endif
        </div>
        @break

    {{-- Text-based inputs (text, email, url, tel, search) --}}
    @default
        <div class="grid gap-2">
            @if($label)
                <label
                    for="{{ $inputId }}"
                    class="text-sm font-medium text-foreground {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                >
                    {{ $label }}
                    @if($required)
                        <span class="text-destructive" aria-label="required">*</span>
                    @endif
                </label>
            @endif

            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $inputId }}"
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                value="{{ old($name, $value) }}"
                class="{{ $baseClasses }} w-full px-3 py-2 text-foreground bg-background border {{ $hasError ? 'border-destructive' : 'border-input' }} rounded-lg focus:outline-none focus:ring-2 {{ $hasError ? 'focus:ring-destructive' : 'focus:ring-ring' }} focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed placeholder:text-muted-foreground"
                autocomplete="{{ $autocomplete }}"
                spellcheck="{{ $spellcheck }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                {{ $attributes->except(['class']) }}
            >

            @if($hasError)
                <p
                    class="text-sm text-destructive"
                    id="{{ $inputId }}-error"
                    role="alert"
                >
                    {{ $errorMessage }}
                </p>
            @endif
        </div>
@endswitch
