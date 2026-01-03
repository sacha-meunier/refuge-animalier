<?php

/*
|--------------------------------------------------------------------------
| Members Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - prefix: admin
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('database')->name('database.')->group(function () {
    Route::livewire('/', 'pages::database.index')
        ->middleware('admin')
        ->name('index');
});
