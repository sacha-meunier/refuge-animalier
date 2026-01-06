@props([
    'title',
    'items' => [],
])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    <h3 class="text-base font-medium text-foreground">
        {{ $title }}
    </h3>
    <div class="space-y-2">
        @foreach($items as $item)
            @if(isset($item['label']))
                <div class="flex flex-col sm:flex-row sm:gap-2 text-sm">
                    <span class="text-muted-foreground min-w-[160px]">{{ $item['label'] }}</span>
                    <span class="text-foreground font-medium">{{ $item['value'] }}</span>
                </div>
            @else
                <p class="text-sm text-foreground">{{ $item }}</p>
            @endif
        @endforeach
    </div>
</div>
