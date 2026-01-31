<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    const STAGE_NOUVEAU = 'nouveau';
    const STAGE_QUALIFIE = 'qualifie';
    const STAGE_PROPOSITION = 'proposition';
    const STAGE_NEGOCIATION = 'negociation';
    const STAGE_CLIENT = 'client';
    const STAGE_PERDU = 'perdu';

    public static function getStages(): array
    {
        return [
            self::STAGE_NOUVEAU => [
                'label' => 'Prospection',
                'description' => 'Nouveau contact créé',
                'color' => 'slate',
                'icon' => 'user-plus',
            ],
            self::STAGE_QUALIFIE => [
                'label' => 'Qualification',
                'description' => 'Intérêt manifesté',
                'color' => 'amber',
                'icon' => 'check-badge',
            ],
            self::STAGE_PROPOSITION => [
                'label' => 'Proposition',
                'description' => 'Offre commerciale envoyée',
                'color' => 'indigo',
                'icon' => 'document-text',
            ],
            self::STAGE_NEGOCIATION => [
                'label' => 'Négociation',
                'description' => 'Discussion des conditions',
                'color' => 'blue',
                'icon' => 'chat-bubble-left-right',
            ],
            self::STAGE_CLIENT => [
                'label' => 'Gagné',
                'description' => 'Client actif',
                'color' => 'emerald',
                'icon' => 'trophy',
            ],
            self::STAGE_PERDU => [
                'label' => 'Perdu',
                'description' => 'Opportunité non aboutie',
                'color' => 'rose',
                'icon' => 'x-circle',
            ],
        ];
    }

    protected $fillable = [
        'user_id_owner',
        'nom',
        'prenom',
        'email',
        'alternative_emails',
        'telephone',
        'alternative_telephones',
        'entreprise',
        'adresse',
        'source',
        'poste',
        'tags',
        'statut',
        'photo',
        'notes_internes',
    ];

    protected $casts = [
        'alternative_emails' => 'json',
        'alternative_telephones' => 'json',
        'tags' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir l'URL de l'avatar (photo ou initiale par défaut)
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        $seed = urlencode($this->nom_complet);
        return "https://ui-avatars.com/api/?name={$seed}&background=6366f1&color=fff&size=256";
    }

    // Relations
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_owner');
    }

    public function user(): BelongsTo // Alias for backward compatibility if needed, or deprecate
    {
        return $this->owner();
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Activity::class, 'parent');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Task::class, 'related');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Scopes
    public function scopeOwnedBy(Builder $query, $userId): Builder
    {
        return $query->where('user_id_owner', $userId);
    }

    public function scopeByUser(Builder $query, $userId): Builder // Keep for Dashboard compatibility
    {
        return $this->scopeOwnedBy($query, $userId);
    }

    public function scopeSearch(Builder $query, $term): Builder
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nom', 'like', "%{$term}%")
              ->orWhere('prenom', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('entreprise', 'like', "%{$term}%");
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('statut', ['perdu', 'inactif']);
    }

    /**
     * Move contact to a new stage and log it.
     */
    public function moveToStage($newStage, $userId = null)
    {
        $oldStage = $this->statut;
        
        if ($oldStage !== $newStage) {
            $this->update(['statut' => $newStage]);

            // Log activity
            $this->activities()->create([
                'user_id' => $userId ?? auth()->id(),
                'type' => 'note',
                'description' => "Changement de statut : " . ($oldStage ?? 'Nouveau') . " → " . $newStage,
                'date_activite' => now(),
                'statut' => 'termine',
            ]);

            // Fire events or specific logic
            if ($newStage === self::STAGE_CLIENT) {
                event(new \App\Events\Contact\ContactUpdated($this)); // Or a specific ClientConverted event
            }

            return true;
        }

        return false;
    }

    /**
     * Get the next logical stage in the pipeline.
     */
    public function getNextStage()
    {
        $order = [
            self::STAGE_NOUVEAU,
            self::STAGE_QUALIFIE,
            self::STAGE_PROPOSITION,
            self::STAGE_NEGOCIATION,
            self::STAGE_CLIENT
        ];

        $currentIndex = array_search($this->statut, $order);
        if ($currentIndex !== false && isset($order[$currentIndex + 1])) {
            return $order[$currentIndex + 1];
        }

        return null;
    }

    // Mutators
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setTelephoneAttribute($value)
    {
        // Simple formatting: remove spaces and dots, ensure limits?
        // For now, just cleanup non-numeric broadly but allow + for international
        // This is a basic mutator as requested.
        $this->attributes['telephone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    // Accessors
    public function getNomCompletAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }
}
