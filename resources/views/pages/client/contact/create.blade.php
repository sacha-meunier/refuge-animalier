<x-client.layout>
    <x-slot:title>
        {!! __('client.title_contact') !!} - {{ config("app.name") }}
    </x-slot>

    <x-client.contact-content />
</x-client.layout>
