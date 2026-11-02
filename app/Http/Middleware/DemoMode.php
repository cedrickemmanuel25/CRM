<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Démonstration publique : bloque les opérations sensibles lorsque DEMO_MODE=true.
 *
 * Restent autorisés : la consultation de tous les écrans et les actions métier courantes
 * (contacts, opportunités, tâches, tickets), annulées par la réinitialisation périodique (demo:reset).
 */
class DemoMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('demo.enabled') && $this->isBlocked($request)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => config('demo.message')], 403);
            }

            return redirect()->back()->withErrors(['demo' => config('demo.message')]);
        }

        return $next($request);
    }

    private function isBlocked(Request $request): bool
    {
        // Aucun fichier téléversé : pas de stockage arbitraire sur le serveur de démonstration
        if (! empty($request->allFiles())) {
            return true;
        }

        // Export complet des comptes utilisateurs
        if ($request->is('admin/export')) {
            return true;
        }

        if ($request->isMethodSafe()) {
            return false;
        }

        return $request->is(
            'admin/*',        // utilisateurs, paramètres, règles, demandes d'accès, maintenance, sauvegarde, RGPD
            'profile',        // e-mail et mot de passe des comptes de démonstration partagés
            'request-access', // formulaire public de demande de compte
        );
    }
}
