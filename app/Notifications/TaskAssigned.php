<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;
use App\Models\NotificationPreference;

class TaskAssigned extends Notification implements ShouldQueue
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
                    ->where('event_type', 'task_assigned')
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
                    ->subject('Nouvelle tâche assignée : ' . $this->task->titre)
                    ->greeting('Bonjour ' . $notifiable->name . ',')
                    ->line('Une nouvelle tâche vous a été assignée.')
                    ->line('Titre : ' . $this->task->titre)
                    ->line('Échéance : ' . ($this->task->due_date ? $this->task->due_date->format('d/m/Y') : 'Aucune'))
                    ->action('Voir la tâche', route('tasks.show', $this->task->id))
                    ->line('Merci de la traiter dans les meilleurs délais.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->titre,
            'message' => 'Nouvelle tâche assignée par ' . ($this->task->creator ? $this->task->creator->name : 'Système'),
            'type' => 'assignment',
        ];
    }
}
