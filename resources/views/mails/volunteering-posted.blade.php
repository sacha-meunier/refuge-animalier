<p>Bonjour, nous avons bien reçu votre demande pour devenir un bénévole chez</p>
<div>{{ config("app.name") }}. Voici les informations que vous avez partagée avec nous</div>
<ul>
    <li>Nom : {{ $volunteerMessage->contact->name }}</li>
    <li>Email : {{ $volunteerMessage->contact->email }}</li>
    <li>Téléphone : {{ $volunteerMessage->contact->phone }}</li>
    @if ($volunteerMessage->contact->address)
        <li>Adresse : {{ $volunteerMessage->contact->address }}</li>
    @endif

</ul>

<p>Date de demande : {{ $volunteerMessage->created_at->format("d/m/Y à H:i") }}</p>
<p>Nous reviendrons vers vous dans les plus brefs délais. Merci,</p>

<p>{{ config("app.name") }}</p>
