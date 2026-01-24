<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactCRUDNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $type; // 'created', 'updated', 'deleted'
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
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // This is handled in the listener by checking preferences,
        // but we can also check here if we want to be safe.
        $channels = ['database'];
        
        // The listener will only notify if preferences allow, 
        // so we can default to both here and let the call logic filter.
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = match($this->type) {
            'created' => "Nouveau Contact : {$this->data['name']}",
            'updated' => "Contact Modifié : {$this->data['name']}",
            'deleted' => "Contact Supprimé : {$this->data['name']}",
        };

        return (new MailMessage)
                    ->subject($title)
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line($title)
                    ->action('Voir le CRM', url('/'))
                    ->line('Merci d\'utiliser notre application !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'entity' => 'contact',
            'title' => match($this->type) {
                'created' => 'Nouveau Contact',
                'updated' => 'Contact Modifié',
                'deleted' => 'Contact Supprimé',
            },
            'name' => $this->data['name'],
            'message' => match($this->type) {
                'created' => "Le contact {$this->data['name']} a été créé.",
                'updated' => "Le contact {$this->data['name']} a été mis à jour.",
                'deleted' => "Le contact {$this->data['name']} a été supprimé.",
            },
            'link' => $this->type !== 'deleted' ? "/contacts/{$this->data['id']}" : null,
        ];
    }
}
