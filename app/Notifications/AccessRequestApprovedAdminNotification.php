<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccessRequestApprovedAdminNotification extends Notification
{
    use Queueable;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'access_request_approved',
            'title' => 'Demande approuvée',
            'message' => "Le compte de {$this->data['user_name']} a été créé. Mot de passe : {$this->data['password']}",
            'user_id' => $this->data['user_id'],
            'url' => route('admin.users.index'),
        ];
    }
}
