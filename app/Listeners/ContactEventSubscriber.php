<?php

namespace App\Listeners;

use App\Events\Contact\ContactCreated;
use App\Events\Contact\ContactUpdated;
use App\Events\Contact\ContactDeleted;
use App\Notifications\ContactCRUDNotification;
use App\Services\NotificationService;
use Illuminate\Events\Dispatcher;

class ContactEventSubscriber
{
    /**
     * Handle contact created events.
     */
    public function handleContactCreated(ContactCreated $event): void {
        NotificationService::send('contact_created', new ContactCRUDNotification('created', [
            'id' => $event->contact->id,
            'name' => $event->contact->nom_complet ?? $event->contact->nom
        ]), $event->contact);
    }

    /**
     * Handle contact updated events.
     */
    public function handleContactUpdated(ContactUpdated $event): void {
        NotificationService::send('contact_updated', new ContactCRUDNotification('updated', [
            'id' => $event->contact->id,
            'name' => $event->contact->nom_complet ?? $event->contact->nom
        ]), $event->contact);
    }

    /**
     * Handle contact deleted events.
     */
    public function handleContactDeleted(ContactDeleted $event): void {
        NotificationService::send('contact_deleted', new ContactCRUDNotification('deleted', [
            'name' => $event->contactName
        ]));
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            ContactCreated::class => 'handleContactCreated',
            ContactUpdated::class => 'handleContactUpdated',
            ContactDeleted::class => 'handleContactDeleted',
        ];
    }
}
