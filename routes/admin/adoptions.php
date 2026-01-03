<?php

use App\Models\Adoption;

/*
|--------------------------------------------------------------------------
| Adoptions Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically wrapped with:
| - prefix: admin
| - middleware: ['auth', 'verified']
|
*/

Route::prefix('adoptions')->name('adoptions.')->group(function () {
    Route::livewire('/', 'pages::adoptions.index')
        ->can('viewAny', Adoption::class)
        ->name('index');
});
