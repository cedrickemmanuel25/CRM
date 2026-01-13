<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:backup-database')->daily()->at('02:00');

// Task Notifications
Schedule::command('tasks:send-reminders')->dailyAt('09:00');
Schedule::command('tasks:send-overdue-alerts')->dailyAt('09:00');
