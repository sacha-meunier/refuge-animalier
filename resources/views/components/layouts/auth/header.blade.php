@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-2xl font-medium text-foreground mb-2">{{ $title }}</h1>
    <p class="text-sm text-muted-foreground">{{ $description }}</p>
</div>
