<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin()) {
            // Redirect to their respective dashboard instead of 403 for better UX?
            // Spec said verify and redirect if not authorized. Let's abort 403 for security distinctness or redirect to user home.
            // "Redirige vers dashboard si non autorisé" - OK.
            
            return redirect()->route(auth()->user()->getDashboardRoute())
                ->with('error', 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
