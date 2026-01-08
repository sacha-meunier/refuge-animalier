@props(["compact" => false])

@php
    $currentLocale = app()->getLocale();
    $locales = collect(config("app.available_locales"))
        ->mapWithKeys(function ($locale) {
            return [$locale => strtoupper($locale)];
        })
        ->toArray();
@endphp

<div class="relative group">
    <button
        type="button"
        class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-foreground hover:text-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-md"
        aria-label="Change language"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"
            />
        </svg>
        <span class="uppercase">{{ $locales[$currentLocale] }}</span>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </button>

    <div
        class="absolute right-0 mt-2 w-32 bg-background border border-border rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 z-50"
    >
        <div class="py-1">
            @foreach ($locales as $code => $label)
                <form
                    method="POST"
                    action="{{ route("locale.change") }}"
                    class="block"
                >
                    @csrf
                    <input type="hidden" name="locale" value="{{ $code }}" />
                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-accent transition-colors {{ $currentLocale === $code ? "bg-accent font-semibold" : "" }}"
                    >
                        {{ $label }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>
</div>
