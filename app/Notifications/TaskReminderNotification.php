<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⏰ Rappel : Tâche à échéance demain')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une tâche importante arrive à échéance demain :')
            ->line('**' . $this->task->titre . '**')
            ->line('Détails : ' . ($this->task->description ?? 'Pas de description supplémentaire.'))
            ->line('Échéance : ' . $this->task->due_date->translatedFormat('d F Y à H:i'))
            ->action('Ouvrir la tâche', url("/tasks/{$this->task->id}"))
            ->line('Pensez à la mettre à jour une fois terminée.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'task_reminder',
            'entity' => 'task',
            'title' => 'Rappel de Tâche',
            'message' => "La tâche \"{$this->task->titre}\" arrive à échéance demain.",
            'link' => "/tasks/{$this->task->id}",
            'task_id' => $this->task->id,
            'due_date' => $this->task->due_date->format('Y-m-d H:i:s'),
        ];
    }
}
