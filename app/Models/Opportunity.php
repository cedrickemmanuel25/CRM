<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Models\OpportunityHistory;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'commercial_id',
        'contact_id',
        'titre',
        'description',
        'montant_estime',
        'stade',
        'probabilite',
        'date_cloture_prev',
        'date_cloture_prev',
        'statut',
        'attribution_mode',
        'assigned_at',
    ];

    protected $casts = [
        'montant_estime' => 'decimal:2',
        'date_cloture_prev' => 'date',
        'probabilite' => 'integer',
        'created_at' => 'datetime',
        'assigned_at' => 'datetime',
    ];

    public function attributionHistory(): HasMany
    {
        return $this->hasMany(OpportunityAttributionHistory::class);
    }

    // Relations
    public function commercial(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Activity::class, 'parent');
    }
    
    public function history(): HasMany
    {
        return $this->hasMany(OpportunityHistory::class);
    }

    // Accessors
    public function getWeightedValueAttribute()
    {
        return $this->montant_estime * ($this->probabilite / 100);
    }

    /**
     * Calcule le nombre de jours passés dans le stade actuel.
     */
    public function getTimeInStageAttribute(): int
    {
        $lastChange = $this->history()->orderBy('changed_at', 'desc')->first();
        
        $startDate = $lastChange ? $lastChange->changed_at : $this->created_at;
        
        return (int) now()->diffInDays($startDate);
    }

    /**
     * Récupère l'historique complet des changements de stade.
     */
    public function getStageHistoryAttribute()
    {
        return $this->history()
            ->with('user')
            ->orderBy('changed_at', 'desc')
            ->get();
    }

    // Methods
    public function moveToStage($newStage, $userId)
    {
        if ($this->stade !== $newStage) {
            $oldStage = $this->stade;
            
            // Update stage
            $this->update(['stade' => $newStage]);
            
            // Log history (OpportunityHistory)
            $this->history()->create([
                'user_id' => $userId,
                'old_stage' => $oldStage,
                'new_stage' => $newStage,
                'changed_at' => now(),
            ]);

            // Log sensitive action in AuditLog
            \App\Models\AuditLog::log('opportunity_stage_change', $this, ['stade' => $oldStage], ['stade' => $newStage]);

            // Fire Events for Notifications
            if ($newStage === 'gagne') {
                event(new \App\Events\Opportunity\OpportunityWon($this));
            } elseif ($newStage === 'perdu') {
                event(new \App\Events\Opportunity\OpportunityLost($this));
            } else {
                event(new \App\Events\Opportunity\OpportunityUpdated($this));
            }

            return true;
        }
        return false;
    }

    // Scopes
    public function scopeByCommercial(Builder $query, $userId): Builder
    {
        return $query->where('commercial_id', $userId);
    }
    
    public function scopeByStage(Builder $query, $stage): Builder
    {
        return $query->where('stade', $stage);
    }

    public function scopeWon(Builder $query): Builder
    {
        return $query->where('stade', 'gagne');
    }

    public function scopeLost(Builder $query): Builder
    {
        return $query->where('stade', 'perdu');
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->whereNotIn('stade', ['gagne', 'perdu']);
    }
    
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('statut', 'actif');
    }
}
