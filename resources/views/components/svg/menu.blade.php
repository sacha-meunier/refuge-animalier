@props(['open' => false])

<x-svg.base {{ $attributes }}>
    @if($open)
        <path d="M18 6 6 18"/>
        <path d="m6 6 12 12"/>
    @else
        <path d="M4 6h16"/>
        <path d="M4 12h16"/>
        <path d="M4 18h16"/>
    @endif
</x-svg.base>
