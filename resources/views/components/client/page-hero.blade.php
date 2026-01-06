@props([
    'title',
    'description',
])

<div class="space-y-4">
    <h1 class="text-4xl sm:text-5xl font-medium text-foreground">
        {{ $title }}
    </h1>
    <p class="text-base sm:text-lg text-muted-foreground max-w-2xl leading-relaxed">
        {{ $description }}
    </p>
</div>
