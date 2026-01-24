<?php

namespace App\Listeners;

use App\Events\Opportunity\OpportunityCreated;
use App\Events\Opportunity\OpportunityUpdated;
use App\Events\Opportunity\OpportunityWon;
use App\Events\Opportunity\OpportunityLost;
use App\Notifications\OpportunityCRUDNotification;
use App\Services\NotificationService;
use Illuminate\Events\Dispatcher;

class OpportunityEventSubscriber
{
    public function handleOpportunityCreated(OpportunityCreated $event): void {
        NotificationService::send('opportunity_created', new OpportunityCRUDNotification('created', [
            'id' => $event->opportunity->id,
            'titre' => $event->opportunity->titre,
            'montant' => $event->opportunity->montant_estime,
            'link' => "/opportunities/{$event->opportunity->id}"
        ]), $event->opportunity);
    }

    public function handleOpportunityUpdated(OpportunityUpdated $event): void {
        NotificationService::send('opportunity_updated', new OpportunityCRUDNotification('updated', [
            'id' => $event->opportunity->id,
            'titre' => $event->opportunity->titre,
            'link' => "/opportunities/{$event->opportunity->id}"
        ]), $event->opportunity);
    }

    public function handleOpportunityWon(OpportunityWon $event): void {
        NotificationService::send('opportunity_won', new OpportunityCRUDNotification('won', [
            'id' => $event->opportunity->id,
            'titre' => $event->opportunity->titre,
            'montant' => $event->opportunity->montant_estime,
            'link' => "/opportunities/{$event->opportunity->id}"
        ]), $event->opportunity);
    }

    public function handleOpportunityLost(OpportunityLost $event): void {
        NotificationService::send('opportunity_lost', new OpportunityCRUDNotification('lost', [
            'id' => $event->opportunity->id,
            'titre' => $event->opportunity->titre,
            'link' => "/opportunities/{$event->opportunity->id}"
        ]), $event->opportunity);
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            OpportunityCreated::class => 'handleOpportunityCreated',
            OpportunityUpdated::class => 'handleOpportunityUpdated',
            OpportunityWon::class => 'handleOpportunityWon',
            OpportunityLost::class => 'handleOpportunityLost',
        ];
    }
}
