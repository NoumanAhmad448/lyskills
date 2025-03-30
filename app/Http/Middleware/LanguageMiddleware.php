<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !is_null(Auth::user()->language)) {
            debug_logs(Auth::check());
            $locale = Auth::user()->language;
            debug_logs($locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
