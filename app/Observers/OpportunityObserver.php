<?php

namespace App\Observers;

use App\Models\Opportunity;
use App\Models\AuditLog;

class OpportunityObserver
{
    /**
     * Handle the Opportunity "created" event.
     */
    public function created(Opportunity $opportunity): void
    {
        AuditLog::log('opportunity_created', $opportunity, null, $opportunity->toArray());
        $this->syncContactStatus($opportunity);
    }

    /**
     * Handle the Opportunity "updated" event.
     */
    public function updated(Opportunity $opportunity): void
    {
        if ($opportunity->wasChanged('stade')) {
            $oldStade = $opportunity->getOriginal('stade');
            $newStade = $opportunity->stade;
            
            AuditLog::log(
                'opportunity_status_change', 
                $opportunity, 
                ['stade' => $oldStade], 
                ['stade' => $newStade]
            );

            $this->syncContactStatus($opportunity);
        } else {
            // Log other important changes
            $changes = $opportunity->getChanges();
            $original = $opportunity->getOriginal();
            
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                AuditLog::log('opportunity_updated', $opportunity, $oldValues, $changes);
            }
        }
    }

    /**
     * Handle the Opportunity "deleted" event.
     */
    public function deleted(Opportunity $opportunity): void
    {
        AuditLog::log('opportunity_deleted', $opportunity, $opportunity->toArray(), null);
        $this->syncContactStatus($opportunity);
    }

    /**
     * Synchronize the associated contact's status with the opportunity's stage.
     */
    protected function syncContactStatus(Opportunity $opportunity): void
    {
        $contact = $opportunity->contact;
        if (!$contact) return;

        // Get all opportunities for this contact
        $opportunities = $contact->opportunities()->get();

        if ($opportunities->isEmpty()) {
            $contact->update(['statut' => null]);
            return;
        }

        // Mapping Opportunity Stage -> Contact Status
        $mapping = [
            'prospection' => 'nouveau',
            'qualification' => 'qualifie',
            'proposition' => 'proposition',
            'negociation' => 'negociation',
            'gagne' => 'client',
            'perdu' => 'perdu',
        ];

        // We want the "most advanced" stage. 
        // Order of precedence (descending)
        $precedence = ['gagne', 'negociation', 'proposition', 'qualification', 'prospection', 'perdu'];

        $bestStage = 'perdu';
        foreach ($precedence as $stage) {
            if ($opportunities->contains('stade', $stage)) {
                $bestStage = $stage;
                break;
            }
        }

        $newStatus = $mapping[$bestStage] ?? null;
        
        if ($contact->statut !== $newStatus) {
            $contact->update(['statut' => $newStatus]);
        }
    }
}
