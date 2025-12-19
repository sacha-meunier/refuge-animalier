@props([
    'title' => null,
    'showAction' => false,
    'actionLabel' => null,
    'actionPermission' => null,
    'actionModel' => null,
])

<header class="h-14 px-6 flex items-center justify-between border-b border-border">
    <div class="flex items-center gap-2 text-sm">
        <span class="font-medium">
            {{ $title ?? $slot }}
        </span>
        <x-svg.chevron-right class="text-muted-foreground"/>
    </div>

    @if($showAction && $actionLabel)
        <div {{ $attributes->only(['class']) }}>
            @if($actionPermission && $actionModel)
                @can($actionPermission, $actionModel)
                    {{ $action ?? '' }}
                @endcan
            @else
                {{ $action ?? '' }}
            @endif
        </div>
    @endif
</header>
