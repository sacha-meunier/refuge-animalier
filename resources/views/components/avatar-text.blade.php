@props([
    'avatar' => null,
    'muted' => false,
])

@php
    $textClasses = $muted ? 'text-muted-foreground' : '';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    @if ($avatar)
        <div class="w-10 h-10 rounded-full bg-muted flex items-center justify-center text-xl">
            {{ $avatar }}
        </div>
    @endif

    <span class="text-sm font-medium {{ $textClasses }}">
        {{ $slot }}
    </span>
</div>
