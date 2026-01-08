<x-mail::message>
# Bonjour {{ $user->name }} 👋

Bienvenue dans l'équipe de **{{ config("app.name") }}** !

Un compte a été créé pour vous afin que vous puissiez accéder à l'interface d'administration du refuge.

## Vos identifiants de connexion

<x-mail::panel>
**Email :** {{ $user->email }}

**Mot de passe :** {{ $password }}
</x-mail::panel>

## Première connexion

<x-mail::button :url="route('login')">
Se connecter
</x-mail::button>

## Important 🔒

Pour des raisons de sécurité, nous vous recommandons vivement de **modifier votre mot de passe** dès votre première connexion.

Vous pouvez le faire depuis les paramètres de votre compte après vous être connecté.

## Besoin d'aide ?

Si vous rencontrez des difficultés ou avez des questions, n'hésitez pas à contacter l'administrateur.

Bienvenue à bord ! 🐾

Cordialement,
L'équipe {{ config("app.name") }}
</x-mail::message>
