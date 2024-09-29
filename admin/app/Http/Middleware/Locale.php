<?php

namespace App\Http\Middleware;

use App\Functions\Core;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Core::setting() && Core::setting('language')) app()->setLocale(Core::setting('language'));
        else if (session()->has('locale')) app()->setLocale(session()->get('locale'));
        return $next($request);
    }
}
