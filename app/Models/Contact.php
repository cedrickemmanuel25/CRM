<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

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
        'notes_internes',
    ];

    protected $casts = [
        'alternative_emails' => 'json',
        'alternative_telephones' => 'json',
        'tags' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
        return $query->where('statut', '!=', 'inactif');
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
}
