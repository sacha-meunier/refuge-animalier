@props([
    'name' => '', // Username
    'image' => null, // Image path if available
    'size' => 'md', // sm, md, lg, xl
    'shape' => 'circle', // circle or square
])

@php
    // Size configurations: [container, font-size with clamp]
    $sizes = [
        'sm' => [
            'container' => 'w-8 h-8',
            'text' => 'text-[clamp(0.625rem,2.5vw,0.75rem)]', // ~10-12px
        ],
        'md' => [
            'container' => 'w-24 h-24',
            'text' => 'text-[clamp(1.5rem,5vw,2rem)]', // ~24-32px
        ],
        'lg' => [
            'container' => 'w-32 h-32',
            'text' => 'text-[clamp(2rem,6vw,2.5rem)]', // ~32-40px
        ],
        'xl' => [
            'container' => 'w-40 h-40',
            'text' => 'text-[clamp(2.5rem,7vw,3rem)]', // ~40-48px
        ],
    ];

    $config = $sizes[$size] ?? $sizes['md'];
    $containerClass = $config['container'];
    $textClass = $config['text'];

    // Shape class based on prop
    $shapeClass = $shape === 'square' ? 'rounded-xl' : 'rounded-full';

    // Extract initials from name
    $getInitials = function($name) {
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    };

    $initials = $getInitials($name);

    // Generate consistent color based on name
    $colors = [
        'bg-blue-500',
        'bg-green-500',
        'bg-yellow-500',
        'bg-red-500',
        'bg-purple-500',
        'bg-pink-500',
        'bg-indigo-500',
        'bg-teal-500',
    ];

    $colorIndex = abs(crc32($name)) % count($colors);
    $bgColor = $colors[$colorIndex];
@endphp

<div {{ $attributes->merge(['class' => 'flex justify-center']) }}>
    @if($image)
        <img
            src="{{ Storage::url($image) }}"
            alt="Avatar de {{ $name }}"
            class="{{ $containerClass }} {{ $shapeClass }} object-cover shadow-lg"
        >
    @else
        <div
            class="{{ $containerClass }} {{ $shapeClass }} {{ $bgColor }} flex items-center justify-center p-2 shadow-lg">
            <span class="{{ $textClass }} font-semibold text-white leading-none">
                {{ $initials }}
            </span>
        </div>
    @endif
</div>
