@props([
    "animals" => [],
])

<section class="w-full bg-accent/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 lg:pt-24">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
            <div class="max-w-3xl">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-balance text-foreground mb-4">
                    {{ __("client.home_animals_title") }}
                </h2>
                <p class="text-lg text-muted-foreground text-balance leading-relaxed">
                    {{ __("client.home_animals_description") }}
                </p>
            </div>

            {{-- View All Link --}}
            <a
                href="{{ route("client.animals.index") }}"
                class="inline-flex items-center px-4 py-2 gap-2 text-primary hover:bg-accent hover:text-primary/80 rounded-full font-medium transition-colors group whitespace-nowrap self-start lg:self-auto"
            >
                <span>{{ __("client.nav_animals") }}</span>
                <x-svg.chevron-right
                    size="sm"
                    class="transition-transform group-hover:translate-x-1"
                />
            </a>
        </div>
    </div>

    <div class="pt-4 sm:pt-6 lg:pt-7 pb-16 sm:pb-20 lg:pb-24">
        {{-- Carousel --}}
        @if ($animals->count() > 0)
            <div
                class="flex gap-4 overflow-x-auto scrollbar-thin pb-4"
                style="scroll-snap-type: x mandatory"
            >
                {{-- Invisible spacer to align first card with header text (max-w-7xl container padding, minus gap) --}}
                <div
                    class="flex-shrink-0 w-0 sm:w-[calc((100vw-min(1280px,100vw-3rem))/2+1.5rem-1rem-1rem)] lg:w-[calc((100vw-min(1280px,100vw-4rem))/2+2rem-1rem-1rem)]"
                    style="scroll-snap-align: start"
                    aria-hidden="true"
                ></div>

                @foreach ($animals as $animal)
                    <x-client.animal-card-wide
                        :animal="$animal"
                        class="w-[75vw] sm:w-[350px] lg:w-[400px]"
                    />
                @endforeach

                <div
                    class="flex-shrink-0 w-2 sm:w-[calc((100vw-min(1280px,100vw-3rem))/2+1.5rem-1rem)] lg:w-[calc((100vw-min(1280px,100vw-4rem))/2+2rem-1rem)]"
                    style="scroll-snap-align: start"
                    aria-hidden="true"
                ></div>
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-muted-foreground text-lg">
                    {{ __("client.no_animals") }}
                </p>
            </div>
        @endif
    </div>
</section>
