<x-client.layout>
    <x-slot:title>
        {!! __('client.title_home') !!} - {{ config("app.name") }}
    </x-slot>

    {{-- Hero Section --}}
    <x-client.home.hero />

    {{-- Statistics Section --}}
    <x-client.home.statistics
        :rescued-this-year="$rescuedThisYear"
        :adopted-this-year="$adoptedThisYear"
        :current-animals="$currentAnimals"
    />

    {{-- Animals Carousel Section --}}
    <x-client.home.animals-carousel :animals="$animals" />
</x-client.layout>
