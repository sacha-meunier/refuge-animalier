<?php

use App\Models\Animal;

/*
|--------------------------------------------------------------------------
| Animals Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - domain: admin.refuge-animalier.test
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('animals')->name('animals.')->group(function () {
    Route::livewire('/', 'pages::animals.index')
        ->can('view-any', Animal::class)
        ->name('index');
});
