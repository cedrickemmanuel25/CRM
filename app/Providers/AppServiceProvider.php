<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force locale to French
        app()->setLocale('fr');
        \Carbon\Carbon::setLocale('fr');
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'fra', 'french');

        // Polymorphic Map
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'contact' => \App\Models\Contact::class,
            'opportunity' => \App\Models\Opportunity::class,
            'user' => \App\Models\User::class,
        ]);

        // Observers
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Opportunity::observe(\App\Observers\OpportunityObserver::class);

        // Auth Events
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            function ($event) {
                \App\Models\AuditLog::log('login', $event->user);
            }
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            function ($event) {
                if ($event->user) {
                    \App\Models\AuditLog::log('logout', $event->user);
                }
            }
        );
    }
}
