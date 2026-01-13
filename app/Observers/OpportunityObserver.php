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
    }
}
