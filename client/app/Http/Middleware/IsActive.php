<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::user()->Owner->status !== 'active') {
            Auth::logout();
            return redirect(RouteServiceProvider::GUEST)->withInput()->with([
                'message' => __('Access denied'),
                'type' => 'error'
            ]);
        }
        return $next($request);
    }
}
