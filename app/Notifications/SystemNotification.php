<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type; // 'user_created', 'error'
    protected $data;

    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $title = $this->type === 'user_created' 
            ? "Nouvel Utilisateur : {$this->data['name']}" 
            : "ERREUR SYSTÈME CRITIQUE 🚨";

        $message = (new MailMessage)
                    ->subject($title)
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line($title);

        if ($this->type === 'error') {
            $message->line("Détails : " . $this->data['message']);
        }

        return $message->action('Accéder au CRM', url('/'))
                    ->line('Merci d\'utiliser notre application !');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'entity' => 'system',
            'title' => $this->type === 'user_created' ? 'Nouvel Utilisateur' : 'Erreur Système',
            'message' => $this->type === 'user_created' 
                ? "L'utilisateur {$this->data['name']} a été créé dans le système." 
                : "Une erreur critique a été détectée : {$this->data['message']}",
            'link' => $this->type === 'user_created' ? "/admin/users" : "/admin/settings",
        ];
    }
}
