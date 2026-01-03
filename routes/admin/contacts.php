<?php

use App\Models\Contact;

/*
|--------------------------------------------------------------------------
| Contacts Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - domain: admin.refuge-animalier.test
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::livewire('/', 'pages::contacts.index')
        ->can('viewAny', Contact::class)
        ->name('index');
});
