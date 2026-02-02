<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Fix for MySQL index length on shared hosting
        Schema::defaultStringLength(191);

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
            'ticket' => \App\Models\Ticket::class,
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

        // Notification Subscribers
        // Removed manual subscription to rely on Laravel Auto-discovery and prevent duplicate notifications
        // \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\ContactEventSubscriber::class);
        // \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\OpportunityEventSubscriber::class);
        // \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\TaskEventSubscriber::class);
        // \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\SystemEventSubscriber::class);
    }
}
