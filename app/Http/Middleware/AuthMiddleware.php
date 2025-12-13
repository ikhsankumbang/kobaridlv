<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user is logged in, otherwise redirect to login page.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
