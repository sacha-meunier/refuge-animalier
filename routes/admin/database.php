<?php

/*
|--------------------------------------------------------------------------
| Members Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - domain: admin.refuge-animalier.test
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('database')->name('database.')->group(function () {
    Route::livewire('/', 'pages::database.index')
        ->middleware('admin')
        ->name('index');
});
