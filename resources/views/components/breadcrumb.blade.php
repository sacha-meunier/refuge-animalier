@props([
    "breadcrumb" => [],
])
<div class="flex items-center gap-2">
    @if (count($breadcrumb) > 0)
        @foreach ($breadcrumb as $index => $crumb)
            @if ($index > 0)
                <x-svg.chevron-right class="h-4 w-4 text-muted-foreground" />
            @endif

            @php
                $isLast = $index === count($breadcrumb) - 1;
                $label = is_array($crumb) ? $crumb["label"] : $crumb;
                $route = is_array($crumb) && isset($crumb["route"]) ? $crumb["route"] : null;
                $href = is_array($crumb) && isset($crumb["href"]) ? $crumb["href"] : null;
            @endphp

            @if ($isLast)
                <span class="text-sm font-medium">
                    {{ $label }}
                </span>
            @else
                <x-button
                    variant="ghost"
                    size="sm"
                    :href="$route ? route($route) : $href"
                >
                    <span class="text-sm text-muted-foreground">
                        {{ $label }}
                    </span>
                </x-button>
            @endif
        @endforeach
    @endif
</div>
