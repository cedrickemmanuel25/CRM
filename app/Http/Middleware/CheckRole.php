<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur a l'un des rôles requis
        if (!$user->hasRole($roles)) {
            abort(403, 'Accès non autorisé. Vous n\'avez pas les permissions nécessaires.');
        }

        return $next($request);
    }
}
