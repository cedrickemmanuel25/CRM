<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'role',
        'status',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
