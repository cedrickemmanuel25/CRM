<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'criteria_type',
        'criteria_value',
        'target_user_id',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    // Scopes    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSource($query)
    {
        return $query->where('criteria_type', 'source');
    }
}
