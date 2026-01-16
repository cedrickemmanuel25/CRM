<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\User;
use App\Models\OpportunityAttributionHistory;
use App\Models\AttributionRule;
use Illuminate\Support\Facades\Auth;

class AttributionService
{
    /**
     * Manually assign an opportunity to a commercial.
     */
    public function assignManually(Opportunity $opportunity, User $commercial, ?User $admin = null): void
    {
        $oldCommercialId = $opportunity->commercial_id;

        // 1. Update Opportunity
        $opportunity->update([
            'commercial_id' => $commercial->id,
            'attribution_mode' => 'manual',
            'assigned_at' => now(),
        ]);

        // 2. Log History
        OpportunityAttributionHistory::create([
            'opportunity_id' => $opportunity->id,
            'assigned_to' => $commercial->id,
            'assigned_by' => $admin ? $admin->id : Auth::id(),
            'mode' => 'manual',
            'reason' => $oldCommercialId ? "Réattribution manuelle (Ancien: " . User::find($oldCommercialId)?->name . ")" : "Première attribution manuelle",
        ]);

        // 3. Notification (TODO: Create Notification class)
        // $commercial->notify(new OpportunityAssigned($opportunity));
    }

    /**
     * Automatically assign an opportunity based on rules.
     */
    public function autoAssign(Opportunity $opportunity): void
    {
        $assignedUser = null;
        $reason = null;

        // 1. Check Rules (Highest Priority First)
        $rules = AttributionRule::query()
            ->active()
            ->orderByDesc('priority')
            ->get();

        foreach ($rules as $rule) {
            // Evaluator Logic
            if ($this->matchRule($rule, $opportunity)) {
                if ($rule->target_user_id) {
                    $assignedUser = $rule->targetUser;
                    $reason = "Règle: {$rule->name}";
                } else {
                    // Load Balancing Rule (No specific target)
                    $assignedUser = $this->findLeastLoadedCommercial();
                    $reason = "Règle: {$rule->name} (Équilibrage)";
                }
                break; // Stop at first match
            }
        }

        // 2. Default Fallback (if no rule matched)
        if (!$assignedUser) {
            $assignedUser = $this->findLeastLoadedCommercial(); // Default strategy
            $reason = "Défaut: Équilibrage de charge";
        }

        if ($assignedUser) {
            $opportunity->update([
                'commercial_id' => $assignedUser->id,
                'attribution_mode' => 'auto',
                'assigned_at' => now(),
            ]);

            OpportunityAttributionHistory::create([
                'opportunity_id' => $opportunity->id,
                'assigned_to' => $assignedUser->id,
                'assigned_by' => null, // System
                'mode' => 'auto',
                'reason' => $reason,
            ]);

            // Notification
            // $assignedUser->notify(new OpportunityAssigned($opportunity));
        }
    }

    /**
     * Check if an opportunity matches a rule criteria.
     */
    protected function matchRule(AttributionRule $rule, Opportunity $opportunity): bool
    {
        return match ($rule->criteria_type) {
            'source' => $opportunity->contact && strtolower($opportunity->contact->source) === strtolower($rule->criteria_value),
            'amount_gt' => $opportunity->montant_estime > (float) $rule->criteria_value,
            'sector' => $opportunity->contact && str_contains(strtolower($opportunity->contact->entreprise), strtolower($rule->criteria_value)), // Basic "Sector" check via company name for now
            default => false,
        };
    }

    /**
     * Find the commercial with the least active opportunities.
     */
    protected function findLeastLoadedCommercial(): ?User
    {
        return User::commercials()
            ->withCount(['opportunities' => function ($query) {
                $query->active();
            }])
            ->orderBy('opportunities_count', 'asc')
            ->first();
    }
}
