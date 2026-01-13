<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'assigned_to',
        'due_date',
        'statut',
        'priority',
        'related_type',
        'related_id',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relations
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function related()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeByUser(Builder $query, $userId): Builder
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeDueToday(Builder $query): Builder
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<', now())->where('statut', '!=', 'done');
    }
    
    // Check if task is completed
    public function isDone(): bool
    {
        return $this->statut === 'done';
    }

    // Methods
    public function markAsDone()
    {
        $this->update(['statut' => 'done']);
    }
}
