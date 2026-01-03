<?php

use App\Models\User;

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

Route::prefix('members')->name('members.')->group(function () {
    Route::livewire('/', 'pages::members.index')
        ->can('viewAny', User::class)
        ->name('index');
});
