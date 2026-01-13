<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('fr');
        \Carbon\Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'fra', 'french');
        
        return $next($request);
    }
}
