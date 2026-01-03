<?php

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - prefix: admin
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('settings')->name('settings.')->group(function () {
    Route::livewire('/', 'pages::settings.index')
        ->name('index');
});
