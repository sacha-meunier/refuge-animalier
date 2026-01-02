<?php

use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', fn() => view('home'))->name('home');
});
