<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccessRequestApprovedNotification extends Notification
{
    use Queueable;
    protected $credentials;

    /**
     * Create a new notification instance.
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre compte CRM est prêt !')
            ->greeting('Bonjour ' . $this->credentials['name'] . ',')
            ->line('Bonne nouvelle ! Votre demande d\'accès au CRM a été approuvée par l\'administrateur.')
            ->line('Voici vos informations de connexion :')
            ->line('**Email :** ' . $this->credentials['email'])
            ->line('**Mot de passe temporaire :** ' . $this->credentials['password'])
            ->action('Se connecter au CRM', url('/login'))
            ->line('Pour des raisons de sécurité, nous vous conseillons de changer votre mot de passe dès votre première connexion.')
            ->line('Bienvenue dans l\'équipe !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
