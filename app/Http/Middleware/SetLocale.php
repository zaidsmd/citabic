<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('localization.supported', ['fr', 'en']);
        $locale = $request->session()->get('locale', config('localization.default', 'fr'));

        if (! in_array($locale, $supported, true)) {
            $locale = config('localization.default', 'fr');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
