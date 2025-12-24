<?php

use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::domain(config('app.admin_domain'))
    ->middleware(['auth', 'verified'])
    ->group(function () {

        // Dashboard
        Route::livewire('/', 'pages::dashboard.index')->name('dashboard');
        Route::redirect('/dashboard', '/');

        require base_path('routes/animals.php');
        require base_path('routes/adoptions.php');
        require base_path('routes/notes.php');
        require base_path('routes/contacts.php');
        require base_path('routes/members.php');
        require base_path('routes/database.php');
        require base_path('routes/settings.php');

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
