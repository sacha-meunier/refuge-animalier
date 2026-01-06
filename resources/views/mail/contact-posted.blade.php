<x-mail::message>
# Bonjour {{ $messageContact->contact->name }} 👋
Merci d'avoir pris le temps de nous contacter !
Nous avons bien reçu votre message.

## Votre message

<x-mail::panel>
    {{ $messageContact->message }}
</x-mail::panel>

## Ce qui se passe maintenant :
Notre équipe va examiner votre demande et vous répondra dans les **48 heures ouvrables**.
Si votre question concerne un animal spécifique ou une urgence, nous vous invitons à nous appeler
directement.

Nous vous remercions pour votre intérêt et votre soutien ! 💙
Cordialement, L'équipe {{ config("app.name") }}

</x-mail::message>
