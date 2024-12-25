<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class BlockSessionWrites
{
    public function handle($request, Closure $next)
    {
        // Block session writes by replacing session handlers
        app()->instance('session', new class
        {
            public function get($key, $default = null)
            {
                return Session::get($key, $default);
            }

            public function has($key)
            {
                return Session::has($key);
            }

            public function forget($key)
            {
                // Block any forget/put/etc.
            }

            public function all()
            {
                return Session::all();
            }
        });

        return $next($request);
    }
}
