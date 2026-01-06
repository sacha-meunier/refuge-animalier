<x-mail::message>
# New Adoption Request
A new adoption request has been submitted for **{{ $adoption->animal->name }}**.

## Contact Information
- **Name**: {{ $adoption->contact->name }}
- **Email**: {{ $adoption->contact->email }}
- **Phone**: {{ $adoption->contact->phone }}
@if ($adoption->contact->address)
- **Address**: {{ $adoption->contact->address }}
@endif

## Animal
- **Name**: {{ $adoption->animal->name }}
- **Species**: {{ $adoption->animal->specie->name }}
- **Breed**: {{ $adoption->animal->breed->name }}

## Message from{{ $adoption->contact->name }}
<x-mail::panel>
    {{ $adoption->content }}
</x-mail::panel>

## Request Details
- **Status**: {{ $adoption->status->label() }}
- **Submitted**: {{ $adoption->created_at->format("d/m/Y à H:i") }}

<x-mail::button :url="route('adoptions.index')">
    View in Admin Dashboard
</x-mail::button>

You received this email because you opted in to receive adoption request
notifications in your settings. Thanks,
{{ config("app.name") }}
</x-mail::message>
