<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShowText
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config("setting.enable_text_showing")) {
            return response()->view("show_text");
        }
        return $next($request);
    }
}
