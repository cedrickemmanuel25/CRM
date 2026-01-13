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

    // ... via ...

    // ... toMail ...

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
        ];
    }

    protected function getUrl()
    {
         switch($this->entityType) {
            case 'contact': return route('contacts.show', $this->entity);
            case 'opportunity': return route('opportunities.show', $this->entity);
            case 'task': return route('tasks.index'); 
            default: return '#';
        }
    }
}
