<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EntityAssigned extends Notification
{
    use Queueable;

    protected $entityType;
    protected $entity;
    protected $assigner;
    protected $message;

    public function __construct($entityType, $entity, $assigner = null, $message = null)
    {
        $this->entityType = $entityType;
        $this->entity = $entity;
        $this->assigner = $assigner;
        $this->message = $message;
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
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'entity_type' => $this->entityType,
            'entity_id' => $this->entity->id,
            'assigner_name' => $this->assigner ? $this->assigner->name : 'Système',
            'message' => $this->message,
            'url' => $this->getActionUrl(),
        ];
    }
    
    protected function getActionUrl()
    {
        switch($this->entityType) {
            case 'contact': return route('contacts.show', $this->entity);
            case 'opportunity': return route('opportunities.show', $this->entity);
            case 'task': return route('tasks.index'); // No show route for tasks yet, maybe modal?
            default: return '#';
        }
    }
}
