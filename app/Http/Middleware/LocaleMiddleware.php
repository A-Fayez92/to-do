<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('locale') && in_array(session('locale'), config('app.supported_locales'))) {
            app()->setLocale(session('locale'));
            if (auth()->check() && auth()->user()->locale !== session('locale')) {
                auth()->user()->update(['locale' => session('locale')]);
            }
        } elseif (auth()->check() && auth()->user()->locale) {
            app()->setLocale(auth()->user()->locale);
            session(['locale' => auth()->user()->locale]);
        } else {
            app()->setLocale(config('app.locale'));
            session(['locale' => config('app.locale')]);
        }

        return $next($request);
    }
}
