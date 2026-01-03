<?php

use App\Models\Adoption;

/*
|--------------------------------------------------------------------------
| Adoptions Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - domain: admin.refuge-animalier.test
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('adoptions')->name('adoptions.')->group(function () {
    Route::livewire('/', 'pages::adoptions.index')
        ->can('viewAny', Adoption::class)
        ->name('index');
});
