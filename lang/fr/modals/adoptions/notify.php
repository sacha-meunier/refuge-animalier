<?php

return [
    // Modal titles
    'title' => 'Notifier le contact',
    'compose_title' => 'Composer la notification',

    // Confirmation modal
    'confirm_message' => 'Souhaitez-vous notifier :name de cette mise à jour de statut ?',
    'current_status' => 'Statut actuel',
    'button_yes' => 'Oui, notifier',
    'button_no' => 'Non, ignorer',

    // Compose modal
    'recipient' => 'Destinataire',
    'animal' => 'Animal',
    'status' => 'Statut',
    'email_content_label' => 'Contenu de l\'e-mail',
    'email_content_placeholder' => 'Rédigez votre message au contact...',
    'email_content_hint' => 'Ce message sera envoyé au contact avec la mise à jour du statut d\'adoption.',
    'button_send' => 'Envoyer la notification',

    // Default message template
    'default_message' => "Bonjour :name,\n\nNous avons une mise à jour concernant votre demande d'adoption pour :animal.\n\nLe statut actuel de votre demande est : :status\n\nNous vous tiendrons informé de tout développement ultérieur.\n\nCordialement,\nL'équipe",

    // Validation messages
    'validation_required' => 'Le contenu de l\'e-mail est requis.',
    'validation_min' => 'Le contenu de l\'e-mail doit contenir au moins 10 caractères.',
    'validation_max' => 'Le contenu de l\'e-mail ne doit pas dépasser 5000 caractères.',

    // Success message
    'success_message' => 'E-mail de notification envoyé avec succès !',
];
