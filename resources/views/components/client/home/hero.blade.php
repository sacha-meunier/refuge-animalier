<section class="w-full bg-gradient-to-b from-accent/30 to-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-32">
        <div class="max-w-3xl mx-auto text-center space-y-8">
            {{-- Title --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-foreground text-balance leading-tight">
                {{ __('client.home_hero_title') }}
            </h1>

            {{-- Description --}}
            <p class="text-lg sm:text-xl text-muted-foreground text-balance leading-relaxed">
                {{ __('client.home_hero_description') }}
            </p>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a
                    href="{{ route('client.animals.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-full text-base font-medium hover:bg-primary/70 transition-colors touch-target w-full sm:w-auto"
                >
                    {{ __('client.home_hero_find_animal') }}
                </a>

                <a
                    href="{{ route('volunteer.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-foreground rounded-full text-base font-medium hover:bg-accent transition-colors touch-target w-full sm:w-auto group"
                >
                    <span>{{ __('client.home_hero_become_volunteer') }}</span>
                    <x-svg.chevron-right size="sm" class="transition-transform group-hover:translate-x-1" />
                </a>
            </div>
        </div>
    </div>
</section>
