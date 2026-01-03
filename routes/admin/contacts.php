<?php

use App\Models\Contact;

/*
|--------------------------------------------------------------------------
| Contacts Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - prefix: admin
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::livewire('/', 'pages::contacts.index')
        ->can('viewAny', Contact::class)
        ->name('index');
});
