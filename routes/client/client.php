<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Animals
    Route::get('/animals', [AnimalController::class, 'index'])->name('client.animals.index');
    Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('client.animals.show');

    // Contact
    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    // Volunteer
    Route::get('/volunteer', [VolunteerController::class, 'create'])->name('volunteer.create');
    Route::post('/volunteer', [VolunteerController::class, 'store'])->name('volunteer.store');
});
