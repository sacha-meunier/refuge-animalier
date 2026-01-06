@props([
    'items' => [],
])

<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex items-center gap-2 text-sm">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-2">
                @if($loop->last)
                    <span class="text-foreground font-medium">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['url'] }}" class="text-muted-foreground hover:text-foreground transition-colors">
                        {{ $item['label'] }}
                    </a>
                    <x-svg.chevron-right size="xs" class="text-muted-foreground" />
                @endif
            </li>
        @endforeach
    </ol>
</nav>
