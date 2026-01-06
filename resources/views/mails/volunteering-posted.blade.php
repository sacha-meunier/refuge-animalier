<x-mail::message>
    # Bonjour {{ $volunteerMessage->contact->name }} 👋

    Merci d'avoir manifesté votre intérêt pour devenir bénévole chez **{{ config("app.name") }}** !
    Nous avons bien reçu votre demande et nous sommes ravis de votre engagement
    pour aider nos animaux.

    ## Récapitulatif de votre demande
    - **Nom** : {{ $volunteerMessage->contact->name }}
    - **Email** : {{ $volunteerMessage->contact->email }}
    - **Téléphone** : {{ $volunteerMessage->contact->phone }}
    @if ($volunteerMessage->contact->address)
    - **Adresse** : {{ $volunteerMessage->contact->address }}
    @endif

    - **Date** : {{ $volunteerMessage->created_at->format("d/m/Y à H:i") }}

    <x-mail::panel>
        **Votre message** :
        {{ $volunteerMessage->message }}
    </x-mail::panel>

    ## Prochaines étapes :
    Notre équipe va examiner votre demande et vous recontacter dans les plus
    brefs délais pour discuter des opportunités de bénévolat disponibles.
    En attendant, n'hésitez pas à consulter notre site pour en savoir
    plus sur nos animaux et notre mission.

    <x-mail::button :url="route('home')">Visiter notre site</x-mail::button>

    Merci encore pour votre générosité ! 💚 Cordialement, L'équipe {{ config("app.name") }}
</x-mail::message>
