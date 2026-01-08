<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        // Dashboard
        Route::livewire('/', 'pages::dashboard.index')->name('dashboard');
        Route::redirect('/dashboard', '/');

        require __DIR__.'/animals.php';
        require __DIR__.'/adoptions.php';
        require __DIR__.'/notes.php';
        require __DIR__.'/messages.php';
        require __DIR__.'/contacts.php';
        require __DIR__.'/members.php';
        require __DIR__.'/database.php';
        require __DIR__.'/settings.php';

        // Development only - Quick user switching
        if (config('app.debug')) {
            Route::get('/dev/login-as/{email}', function (string $email) {
                $user = \App\Models\User::where('email', $email)->firstOrFail();
                Auth::login($user);

                return redirect()->route('dashboard');
            })->name('dev.login-as');
        }

        Route::fallback(function () {
            return redirect()->route('dashboard');
        });
    });
