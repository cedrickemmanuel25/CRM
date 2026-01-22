<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EntityActionNotification extends Notification
{
    use Queueable;

    protected $action;
    protected $entity;
    protected $entityType;
    protected $message;
    protected $performer;

    public function __construct($action, $entity, $entityType, $message, $performer = null)
    {
        $this->action = $action;
        $this->entity = $entity;
        $this->entityType = $entityType;
        $this->message = $message;
        $this->performer = $performer;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = match($this->action) {
            'created' => 'Nouvel élément créé',
            'updated' => 'Élément mis à jour',
            'deleted' => 'Élément supprimé',
            default => 'Action sur un élément',
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($this->message)
            ->action('Voir les détails', $this->getUrl())
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
            'action' => $this->action,
            'entity_type' => $this->entityType,
            'entity_id' => $this->entity->id,
            'message' => $this->message,
            'performer_name' => $this->performer ? $this->performer->name : 'Système',
            'url' => $this->getUrl(),
            'action_url' => $this->getUrl(),
        ];
    }

    protected function getUrl()
    {
         switch($this->entityType) {
            case 'contact': return route('contacts.show', $this->entity);
            case 'opportunity': return route('opportunities.show', $this->entity);
            case 'ticket': return route('tickets.show', $this->entity);
            case 'task': return route('tasks.index'); 
            default: return '#';
        }
    }
}
