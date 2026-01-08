<?php

use Illuminate\Support\Facades\Route;

Route::prefix('messages')
    ->name('messages.')
    ->group(function () {
        Route::livewire('/', 'pages::messages.index')->name('index');
    });
