<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;
use App\Models\NotificationPreference;

class TaskReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via(object $notifiable): array
    {
        // Default channels
        $channels = ['database', 'mail'];
        
        // Check preferences
        $pref = NotificationPreference::where('user_id', $notifiable->id)
                    ->where('event_type', 'task_reminder')
                    ->first();

        if ($pref) {
            $channels = [];
            if ($pref->database) $channels[] = 'database';
            if ($pref->mail) $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Rappel : Tache arrivant à échéance')
                    ->greeting('Bonjour ' . $notifiable->name . ',')
                    ->line('La tâche suivante arrive bientôt à échéance :')
                    ->line('Titre : ' . $this->task->titre)
                    ->line('Échéance : ' . $this->task->due_date->format('d/m/Y'))
                    ->action('Accéder à la tâche', route('tasks.show', $this->task->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->titre,
            'message' => 'Rappel : "' . $this->task->titre . '" arrive à échéance le ' . $this->task->due_date->format('d/m/Y'),
            'type' => 'reminder',
        ];
    }
}
