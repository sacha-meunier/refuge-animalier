@props([
    "animal",
])

<a
    href="{{ route("client.animals.show", $animal) }}"
    {{ $attributes->merge(["class" => "group block bg-card border border-border rounded-2xl overflow-hidden hover:shadow-lg hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all touch-target"]) }}
>
    {{-- Image --}}
    <div class="aspect-[4/3] bg-muted overflow-hidden">
        @if ($animal->pictures && ! empty($animal->pictures))
            <img
                src="{{ $animal->image_thumbnail_url }}"
                srcset="
                    {{ $animal->image_thumbnail_url }}  150w,
                    {{ $animal->image_medium_url }}     500w,
                    {{ $animal->image_url }}           1000w
                "
                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                alt="{{ $animal->name }}"
                class="w-full h-full object-cover"
                loading="lazy"
            />
        @else
            <div
                class="w-full h-full flex items-center justify-center text-muted-foreground"
            >
                <x-svg.dog size="2xl" class="opacity-50" />
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4 relative">
        <div class="pr-10 flex flex-col">
            {{-- Animal name --}}
            <h3
                class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors order-2"
            >
                {{ $animal->name }}
            </h3>

            {{-- Breed + Age --}}
            <p class="text-sm text-muted-foreground mb-1 order-1">
                {{ $animal->breed?->name ?? __("client.unknown_breed") }} ·
                {{ $animal->formatted_age ?? __("client.unknown_age") }}
            </p>
        </div>

        {{-- Arrow button --}}
        <div class="absolute right-4 top-1/2 -translate-y-1/2">
            <x-client.icon-button>
                <x-svg.arrow-up-right size="sm" />
            </x-client.icon-button>
        </div>
    </div>
</a>
