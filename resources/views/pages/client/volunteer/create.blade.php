<x-client.layout>
    <x-slot:title>
        {!! __('client.title_volunteer') !!} - {{ config("app.name") }}
    </x-slot>

    <x-client.volunteer-content />
</x-client.layout>
