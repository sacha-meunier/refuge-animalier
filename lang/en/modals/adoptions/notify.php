<?php

return [
    // Modal titles
    'title' => 'Notify Contact',
    'compose_title' => 'Compose Notification',

    // Confirmation modal
    'confirm_message' => 'Would you like to notify :name about this status update?',
    'current_status' => 'Current Status',
    'button_yes' => 'Yes, Notify',
    'button_no' => 'No, Skip',

    // Compose modal
    'recipient' => 'Recipient',
    'animal' => 'Animal',
    'status' => 'Status',
    'email_content_label' => 'Email Content',
    'email_content_placeholder' => 'Write your message to the contact...',
    'email_content_hint' => 'This message will be sent to the contact along with the adoption status update.',
    'button_send' => 'Send Notification',

    // Default message template
    'default_message' => "Hello :name,\n\nWe have an update regarding your adoption request for :animal.\n\nThe current status of your request is: :status\n\nWe will keep you informed of any further developments.\n\nBest regards,\nThe Team",

    // Validation messages
    'validation_required' => 'The email content is required.',
    'validation_min' => 'The email content must be at least 10 characters.',
    'validation_max' => 'The email content must not exceed 5000 characters.',

    // Success message
    'success_message' => 'Notification email sent successfully!',
];
