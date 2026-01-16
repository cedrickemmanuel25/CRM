<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        // Rate limiting pour prévenir les attaques par force brute
        $key = 'login.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            throw ValidationException::withMessages([
                'email' => ["Trop de tentatives de connexion. Réessayez dans {$seconds} secondes."],
            ]);
        }

        // Tentative d'authentification
        $remember = $request->boolean('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            // Régénérer la session pour prévenir la fixation de session
            $request->session()->regenerate();
            
            // Effacer le rate limiter
            RateLimiter::clear($key);
            
            $user = Auth::user();
            
            // Log d'audit pour la connexion réussie
            \App\Models\AuditLog::log('login', $user, null, ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]);
            Log::info('Connexion réussie', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            // Redirection selon le rôle
            $dashboardRoute = $user->getDashboardRoute();
            
            // On force la redirection vers le dashboard pour éviter de tomber sur une URL d'API (JSON) capturée par intended()
            return redirect()->route($dashboardRoute)
                ->with('success', "Bienvenue {$user->name}!");
        }

        // Incrémenter le compteur de tentatives
        RateLimiter::hit($key, 60);

        // Log d'audit pour la tentative échouée
        // AuditLog::log('login_failed', null, null, ['email' => $request->email, 'ip' => $request->ip()]); // Optional: Log failed attempts to DB? Might flood. width Log facade is enough.
        Log::warning('Tentative de connexion échouée', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        // Retourner avec erreur
        throw ValidationException::withMessages([
            'email' => ['Les identifiants fournis sont incorrects.'],
        ]);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log d'audit pour la déconnexion
        if ($user) {
            \App\Models\AuditLog::log('logout', $user, null, ['ip' => $request->ip()]);
            Log::info('Déconnexion', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
        }

        // Déconnexion
        Auth::logout();

        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
