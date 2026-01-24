<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCRUDNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type; // 'created', 'completed', 'overdue'
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = match($this->type) {
            'created' => "Nouvelle Tâche : {$this->data['titre']}",
            'completed' => "Tâche Terminée : {$this->data['titre']}",
            'overdue' => "Tâche EN RETARD ⚠️ : {$this->data['titre']}",
        };

        return (new MailMessage)
                    ->subject($title)
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line($title)
                    ->action('Accéder à la tâche', url($this->data['link'] ?? '/'))
                    ->line('Merci d\'utiliser notre application !');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'entity' => 'task',
            'title' => match($this->type) {
                'created' => 'Nouvelle Tâche',
                'completed' => 'Tâche Terminée',
                'overdue' => 'Tâche en RETARD',
            },
            'titre' => $this->data['titre'],
            'message' => match($this->type) {
                'created' => "Une nouvelle tâche vous a été assignée : {$this->data['titre']}.",
                'completed' => "La tâche {$this->data['titre']} a été marquée comme terminée.",
                'overdue' => "Attention, la tâche {$this->data['titre']} est en retard.",
            },
            'link' => $this->data['link'] ?? null,
        ];
    }
}
