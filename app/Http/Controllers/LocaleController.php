<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Change the user's locale.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->locale && in_array($request->locale, config('app.supported_locales'))) {
            session(['locale' => $request->locale]);

            if (auth()->check() && auth()->user()->locale !== $request->locale) {
                auth()->user()->update(['locale' => $request->locale]);
            }
        }
        return redirect()->back();
    }
}
