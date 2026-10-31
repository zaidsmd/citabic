<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('localization.supported', ['fr', 'en', 'ar']);
        $locale = $request->session()->get('locale')
            ?? $request->cookie('locale')
            ?? $request->getPreferredLanguage($supported)
            ?? config('localization.default', 'fr');

        if (! in_array($locale, $supported, true)) {
            $locale = config('localization.default', 'fr');
        }

        if ($request->session()->get('locale') !== $locale) {
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        $response = $next($request);

        $finalLocale = $request->session()->get('locale', $locale);
        if (! in_array($finalLocale, $supported, true)) {
            $finalLocale = $locale;
        }

        if ($request->cookie('locale') !== $finalLocale) {
            $response->headers->setCookie(cookie()->forever('locale', $finalLocale));
        }

        return $response;
    }
}
