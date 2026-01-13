<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification implements ShouldQueue
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
        $daysOverdue = now()->diffInDays($this->task->due_date);
        
        return (new MailMessage)
            ->subject('⚠️ Tâche en retard')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous avez une tâche en retard :')
            ->line('**' . $this->task->titre . '**')
            ->line('Description : ' . ($this->task->description ?? 'Aucune description'))
            ->line('Échéance dépassée depuis : ' . $daysOverdue . ' jour(s)')
            ->line('Priorité : ' . strtoupper($this->task->priority))
            ->action('Voir la tâche', route('tasks.index'))
            ->line('Merci de traiter cette tâche dès que possible.')
            ->error();
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
            'days_overdue' => now()->diffInDays($this->task->due_date),
            'priority' => $this->task->priority,
            'type' => 'task_overdue',
            'message' => 'La tâche "' . $this->task->titre . '" est en retard.',
        ];
    }
}
