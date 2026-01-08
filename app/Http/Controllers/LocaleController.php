<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Change the application locale.
     */
    public function change(Request $request): RedirectResponse
    {
        $availableLocales = implode(',', config('app.available_locales'));

        $validated = $request->validate([
            'locale' => "required|string|in:{$availableLocales}",
        ]);

        Session::put('locale', $validated['locale']);

        return redirect()->back();
    }
}
