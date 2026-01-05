@props([
    'rescuedThisYear' => 0,
    'adoptedThisYear' => 0,
    'currentAnimals' => 0,
])

<section class="w-full bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
        {{-- Header --}}
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground text-balance mb-4">
                {{ __('client.home_stats_title') }}
            </h2>
            <p class="text-lg text-muted-foreground text-balance leading-relaxed">
                {{ __('client.home_stats_description') }}
            </p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            {{-- Rescued This Year --}}
            <div class="bg-card border border-border rounded-2xl p-6 lg:p-8 text-center space-y-2">
                <div class="text-4xl lg:text-5xl font-bold text-primary">
                    {{ $rescuedThisYear }}
                </div>
                <p class="text-sm lg:text-base text-muted-foreground">
                    {{ __('client.home_stats_rescued') }}
                </p>
            </div>

            {{-- Adopted This Year --}}
            <div class="bg-card border border-border rounded-2xl p-6 lg:p-8 text-center space-y-2">
                <div class="text-4xl lg:text-5xl font-bold text-primary">
                    {{ $adoptedThisYear }}
                </div>
                <p class="text-sm lg:text-base text-muted-foreground">
                    {{ __('client.home_stats_adopted') }}
                </p>
            </div>

            {{-- Currently With Us --}}
            <div class="bg-card border border-border rounded-2xl p-6 lg:p-8 text-center space-y-2">
                <div class="text-4xl lg:text-5xl font-bold text-primary">
                    {{ $currentAnimals }}
                </div>
                <p class="text-sm lg:text-base text-muted-foreground">
                    {{ __('client.home_stats_current') }}
                </p>
            </div>
        </div>
    </div>
</section>
