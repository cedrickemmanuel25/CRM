<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    
    // Relations
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id_owner');
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'commercial_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    // Constantes pour les rôles
    public const ROLE_ADMIN = 'admin';
    public const ROLE_COMMERCIAL = 'commercial';
    public const ROLE_SUPPORT = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telephone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope pour filtrer les administrateurs
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Scope pour filtrer les commerciaux
     */
    public function scopeCommercials($query)
    {
        return $query->where('role', self::ROLE_COMMERCIAL);
    }

    /**
     * Scope pour filtrer les supports
     */
    public function scopeSupports($query)
    {
        return $query->where('role', self::ROLE_SUPPORT);
    }

    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Vérifier si l'utilisateur est commercial
     */
    public function isCommercial(): bool
    {
        return $this->role === self::ROLE_COMMERCIAL;
    }

    /**
     * Vérifier si l'utilisateur est support
     */
    public function isSupport(): bool
    {
        return $this->role === self::ROLE_SUPPORT;
    }



    /**
     * Vérifier si l'utilisateur a un rôle spécifique
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        
        return $this->role === $roles;
    }

    /**
     * Obtenir le dashboard URL selon le rôle
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_COMMERCIAL => 'commercial.dashboard',
            self::ROLE_SUPPORT => 'support.dashboard',
            default => 'dashboard',
        };
    }
}

