<x-client.layout>
    <x-slot:title>
        {!! __('client.title_animals') !!} - {{ config("app.name") }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        {{-- Header with title and search --}}
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 sm:mb-12"
        >
            <h1
                class="text-3xl sm:text-4xl lg:text-4xl font-bold text-foreground"
            >
                {{ __("client.animals_heading") }}
            </h1>

            {{-- Search field --}}
            <form
                method="GET"
                action="{{ route("client.animals.index") }}"
                class="w-full sm:w-auto"
            >
                <div class="relative">
                    <div
                        class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                    >
                        <x-svg.search size="sm" class="text-muted-foreground" />
                    </div>
                    <input
                        type="search"
                        name="search"
                        value="{{ request("search") }}"
                        placeholder="{{ __("client.animals_search_placeholder") }}"
                        class="w-full sm:w-64 lg:w-80 pl-11 pr-4 py-2.5 bg-background border border-border rounded-full text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors touch-target"
                    />
                </div>
            </form>
        </div>

        {{-- Animals grid --}}
        @if ($animals->count() > 0)
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8"
            >
                @foreach ($animals as $animal)
                    <x-client.animal-card :animal="$animal" />
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-end">
                {{ $animals->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-muted-foreground text-lg">
                    {{ __("client.no_animals") }}
                </p>
            </div>
        @endif
    </div>
</x-client.layout>
