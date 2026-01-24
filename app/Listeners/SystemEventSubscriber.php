<?php

namespace App\Listeners;

use App\Events\System\UserCreated;
use App\Events\System\SystemError;
use App\Notifications\SystemNotification;
use App\Services\NotificationService;
use Illuminate\Events\Dispatcher;

class SystemEventSubscriber
{
    public function handleUserCreated(UserCreated $event): void {
        NotificationService::send('user_created', new SystemNotification('user_created', [
            'id' => $event->user->id,
            'name' => $event->user->name
        ]));
    }

    public function handleSystemError(SystemError $event): void {
        NotificationService::send('error', new SystemNotification('error', [
            'message' => $event->message
        ]));
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            UserCreated::class => 'handleUserCreated',
            SystemError::class => 'handleSystemError',
        ];
    }
}
