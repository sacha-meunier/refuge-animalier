<?php

return [
    // Modal titles
    'title' => 'Contact op de hoogte brengen',
    'compose_title' => 'Melding opstellen',

    // Confirmation modal
    'confirm_message' => 'Wilt u :name op de hoogte brengen van deze statusupdate?',
    'current_status' => 'Huidige status',
    'button_yes' => 'Ja, op de hoogte brengen',
    'button_no' => 'Nee, overslaan',

    // Compose modal
    'recipient' => 'Ontvanger',
    'animal' => 'Dier',
    'status' => 'Status',
    'email_content_label' => 'E-mailinhoud',
    'email_content_placeholder' => 'Schrijf uw bericht aan het contact...',
    'email_content_hint' => 'Dit bericht wordt samen met de update van de adoptiestatus naar het contact verzonden.',
    'button_send' => 'Melding verzenden',

    // Default message template
    'default_message' => "Hallo :name,\n\nWe hebben een update over uw adoptieverzoek voor :animal.\n\nDe huidige status van uw verzoek is: :status\n\nWe houden u op de hoogte van verdere ontwikkelingen.\n\nMet vriendelijke groet,\nHet team",

    // Validation messages
    'validation_required' => 'De e-mailinhoud is verplicht.',
    'validation_min' => 'De e-mailinhoud moet minimaal 10 tekens bevatten.',
    'validation_max' => 'De e-mailinhoud mag niet meer dan 5000 tekens bevatten.',

    // Success message
    'success_message' => 'Meldings-e-mail succesvol verzonden!',
];
