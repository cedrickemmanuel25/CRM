<?php

namespace App\Listeners;

use App\Events\Task\TaskCreated;
use App\Events\Task\TaskCompleted;
use App\Events\Task\TaskOverdue;
use App\Notifications\TaskCRUDNotification;
use App\Services\NotificationService;
use Illuminate\Events\Dispatcher;

class TaskEventSubscriber
{
    public function handleTaskCreated(TaskCreated $event): void {
        NotificationService::send('task_created', new TaskCRUDNotification('created', [
            'id' => $event->task->id,
            'titre' => $event->task->titre,
            'link' => "/tasks" // Assumed generic link for now
        ]));
    }

    public function handleTaskCompleted(TaskCompleted $event): void {
        NotificationService::send('task_completed', new TaskCRUDNotification('completed', [
            'id' => $event->task->id,
            'titre' => $event->task->titre,
            'link' => "/tasks"
        ]));
    }

    public function handleTaskOverdue(TaskOverdue $event): void {
        NotificationService::send('task_overdue', new TaskCRUDNotification('overdue', [
            'id' => $event->task->id,
            'titre' => $event->task->titre,
            'link' => "/tasks"
        ]));
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            TaskCreated::class => 'handleTaskCreated',
            TaskCompleted::class => 'handleTaskCompleted',
            TaskOverdue::class => 'handleTaskOverdue',
        ];
    }
}
