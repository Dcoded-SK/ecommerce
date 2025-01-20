<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the authenticated user has the required role
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }

        // Abort with a 403 error if the user does not have the required role
        abort(403, 'You do not have access to open this page');
    }
}