<?php

use App\Models\Note;

/*
|--------------------------------------------------------------------------
| Notes Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - prefix: admin
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('notes')->name('notes.')->group(function () {
    Route::livewire('/', 'pages::notes.index')
        ->can('viewAny', Note::class)
        ->name('index');
});
