<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminFromUserFeatures
{
    /**
     * Handle an incoming request.
     * Prevents admin users from accessing user-specific features like cart, checkout, and orders.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->name === 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Admin users cannot access user features. Please use the admin panel to manage the system.');
        }

        return $next($request);
    }
}
