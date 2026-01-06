@props([
    "species" => [],
    "breeds" => [],
    "coats" => [],
])

<details class="relative group">
    <summary
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-background border border-border rounded-full text-sm font-medium text-foreground hover:bg-accent transition-colors cursor-pointer select-none touch-target list-none"
    >
        <x-svg.filter size="sm" />
        <span>{{ __("client.filters") }}</span>
        <svg
            class="w-4 h-4 transition-transform group-open:rotate-180"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </summary>

    <div
        class="absolute right-0 mt-2 w-72 bg-card border border-border rounded-lg shadow-lg z-10 p-4 space-y-4"
    >
        <form
            method="GET"
            action="{{ route("client.animals.index") }}"
            class="space-y-4"
        >
            {{-- Preserve search query --}}
            @if (request("search"))
                <input
                    type="hidden"
                    name="search"
                    value="{{ request("search") }}"
                />
            @endif

            {{-- Species Filter --}}
            @if ($species->count() > 0)
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">
                        {{ __("client.filter_specie") }}
                    </label>
                    <select
                        name="specie_id"
                        class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    >
                        <option value="">
                            {{ __("client.all_species") }}
                        </option>
                        @foreach ($species as $specie)
                            <option
                                value="{{ $specie->id }}"
                                @selected(request("specie_id") == $specie->id)
                            >
                                {{ $specie->name }}
                                ({{ $specie->animals_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Breed Filter --}}
            @if ($breeds->count() > 0)
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">
                        {{ __("client.filter_breed") }}
                    </label>
                    <select
                        name="breed_id"
                        class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    >
                        <option value="">{{ __("client.all_breeds") }}</option>
                        @foreach ($breeds as $breed)
                            <option
                                value="{{ $breed->id }}"
                                @selected(request("breed_id") == $breed->id)
                            >
                                {{ $breed->name }}
                                ({{ $breed->animals_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Coat Filter --}}
            @if ($coats->count() > 0)
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">
                        {{ __("client.filter_coat") }}
                    </label>
                    <select
                        name="coat_id"
                        class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    >
                        <option value="">{{ __("client.all_coats") }}</option>
                        @foreach ($coats as $coat)
                            <option
                                value="{{ $coat->id }}"
                                @selected(request("coat_id") == $coat->id)
                            >
                                {{ $coat->name }} ({{ $coat->animals_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-2 pt-2">
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors touch-target"
                >
                    {{ __("client.apply_filters") }}
                </button>
                @if (request()->hasAny(["specie_id", "breed_id", "coat_id"]))
                    <a
                        href="{{ route("client.animals.index", request()->only("search")) }}"
                        class="px-4 py-2 bg-secondary text-secondary-foreground rounded-lg text-sm font-medium hover:bg-secondary/80 transition-colors touch-target"
                    >
                        {{ __("client.reset_filters") }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</details>
