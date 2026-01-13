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
            ->subject('Rappel : Tâche à échéance demain')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous avez une tâche qui arrive à échéance demain :')
            ->line('**' . $this->task->titre . '**')
            ->line('Description : ' . ($this->task->description ?? 'Aucune description'))
            ->line('Échéance : ' . $this->task->due_date->format('d/m/Y à H:i'))
            ->action('Voir la tâche', route('tasks.index'))
            ->line('Merci de bien vouloir la traiter dans les délais.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->titre,
            'task_description' => $this->task->description,
            'due_date' => $this->task->due_date->format('Y-m-d H:i:s'),
            'type' => 'task_reminder',
            'message' => 'Rappel : La tâche "' . $this->task->titre . '" arrive à échéance demain.',
        ];
    }
}
