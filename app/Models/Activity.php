<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'parent_type',
        'type',
        'priorite',
        'description',
        'contenu',
        'date_activite',
        'duree',
        'piece_jointe',
        'statut',
    ];

    protected $casts = [
        'date_activite' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function parent()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeByUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent(Builder $query, $limit = 5): Builder
    {
        return $query->orderBy('date_activite', 'desc')->limit($limit);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('statut', 'termine');
    }

    public function scopePlanifie(Builder $query): Builder
    {
        return $query->where('statut', 'planifie');
    }
}
