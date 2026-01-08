<x-mail::message>
# Bonjour {{ $adoption->contact->name }} 👋
Merci d'avoir manifesté votre intérêt pour l'adoption de **{{ $adoption->animal->name }}** !
Nous avons bien reçu votre demande et nous sommes ravis de votre engagement à
offrir un foyer aimant à l'un de nos animaux.
## Récapitulatif de votre demande
- **Animal** : {{ $adoption->animal->name }}
- **Espèce** : {{ $adoption->animal->specie->name }}
- **Race** : {{ $adoption->animal->breed->name }}
- **Votre nom** : {{ $adoption->contact->name }}
- **Email** : {{ $adoption->contact->email }}
- **Téléphone** : {{ $adoption->contact->phone }}

- **Date de demande** : {{ $adoption->created_at->format("d/m/Y à H:i") }}

<x-mail::panel>
**Votre message** :
{{ $adoption->content }}
</x-mail::panel>

## Prochaines étapes
Notre équipe va examiner votre demande d'adoption et vous recontacter dans les
**2-3 jours ouvrables** pour :
1. Discuter de vos motivations et de votre situation
2. Organiser une visite au refuge pour rencontrer {{ $adoption->animal->name }}
3. Vous accompagner dans le processus d'adoption

<x-mail::button :url="route('client.animals.show', $adoption->animal)">
Voir la fiche de {{ $adoption->animal->name }}
</x-mail::button>

Merci de votre patience et de votre engagement envers le bien-être animal !
💚 Cordialement, L'équipe {{ config("app.name") }}

**Besoin de nous contacter ?**
N'hésitez pas à nous appeler ou à nous écrire si vous avez des questions.
</x-mail::message>
