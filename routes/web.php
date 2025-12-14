<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::domain('admin.refuge-animalier.test')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name(
            'dashboard',
        );
    });
});
