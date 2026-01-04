@props([
    'title',
    'missions' => [],
])

<div class="space-y-5">
    <h3 class="text-base font-medium text-foreground">
        {{ $title }}
    </h3>
    <div class="space-y-3.5">
        @foreach($missions as $mission)
            <div class="space-y-0.5">
                <p class="text-sm text-muted-foreground">{{ $mission['category'] }}</p>
                <p class="text-sm text-foreground font-medium">{{ $mission['description'] }}</p>
            </div>
        @endforeach
    </div>
</div>
