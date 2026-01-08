<?php

return [
    // Modal titles
    'title' => 'Kontakt benachrichtigen',
    'compose_title' => 'Benachrichtigung verfassen',

    // Confirmation modal
    'confirm_message' => 'Möchten Sie :name über diese Statusaktualisierung benachrichtigen?',
    'current_status' => 'Aktueller Status',
    'button_yes' => 'Ja, benachrichtigen',
    'button_no' => 'Nein, überspringen',

    // Compose modal
    'recipient' => 'Empfänger',
    'animal' => 'Tier',
    'status' => 'Status',
    'email_content_label' => 'E-Mail-Inhalt',
    'email_content_placeholder' => 'Schreiben Sie Ihre Nachricht an den Kontakt...',
    'email_content_hint' => 'Diese Nachricht wird zusammen mit der Aktualisierung des Adoptionsstatus an den Kontakt gesendet.',
    'button_send' => 'Benachrichtigung senden',

    // Default message template
    'default_message' => "Hallo :name,\n\nWir haben eine Aktualisierung zu Ihrem Adoptionsantrag für :animal.\n\nDer aktuelle Status Ihres Antrags ist: :status\n\nWir werden Sie über weitere Entwicklungen auf dem Laufenden halten.\n\nMit freundlichen Grüßen,\nDas Team",

    // Validation messages
    'validation_required' => 'Der E-Mail-Inhalt ist erforderlich.',
    'validation_min' => 'Der E-Mail-Inhalt muss mindestens 10 Zeichen lang sein.',
    'validation_max' => 'Der E-Mail-Inhalt darf nicht mehr als 5000 Zeichen umfassen.',

    // Success message
    'success_message' => 'Benachrichtigungs-E-Mail erfolgreich gesendet!',
];
