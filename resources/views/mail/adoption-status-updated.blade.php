<x-mail::message>
# Bonjour {{ $adoption->contact->name }} 👋
Nous avons une mise à jour concernant votre demande d'adoption pour **{{ $adoption->animal->name }}**.

## Statut actuel

<x-mail::panel>**{{ $adoption->status->label() }}**</x-mail::panel>

## Message de notre équipe

{{ $customMessage }}

<x-mail::button :url="route('client.animals.show', $adoption->animal)">
Voir la fiche de {{ $adoption->animal->name }}
</x-mail::button>

Si vous avez des questions, n'hésitez pas à nous contacter directement.
Cordialement, L'équipe {{ config("app.name") }}
</x-mail::message>
