<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SendInfoMail
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
        $cacheKey = 'last_email_sent_date';
        $today = now()->toDateString();

        if (Cache::get($cacheKey) !== $today) {
            Cache::put($cacheKey, $today, now()->endOfDay());
            Artisan::call("notify:send");
        }

        return $next($request);
    }
}
