<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAccessRequestNotification extends Notification
{
    use Queueable;
    protected $accessRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct($accessRequest)
    {
        $this->accessRequest = $accessRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle demande d\'accès - ' . company_name())
            ->line('Une nouvelle personne a demandé l\'accès au CRM.')
            ->line('Nom : ' . $this->accessRequest->prenom . ' ' . $this->accessRequest->nom)
            ->line('Email : ' . $this->accessRequest->email)
            ->line('Rôle demandé : ' . $this->accessRequest->role)
            ->action('Gérer les demandes', route('admin.access-requests.index'))
            ->line('Merci de traiter cette demande dès que possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_access_request',
            'title' => 'Nouvelle demande d\'accès',
            'message' => $this->accessRequest->prenom . ' ' . $this->accessRequest->nom . ' a demandé un accès ' . $this->accessRequest->role . '.',
            'request_id' => $this->accessRequest->id,
            'url' => route('admin.access-requests.index'),
        ];
    }
}
