<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    // Home
    Route::get('/', fn() => view('home'))->name('home');

    // Animals
    Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
    Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');

    // Contact
    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');

    // Volunteer
    Route::get('/volunteer', [VolunteerController::class, 'create'])->name('volunteer.create');
});
