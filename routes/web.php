<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::post('/locale/change', [LocaleController::class, 'change'])->name('locale.change');

require __DIR__.'/admin/admin.php';
require __DIR__.'/client/client.php';
