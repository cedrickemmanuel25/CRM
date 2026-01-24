<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'action', 
        'model_type', 
        'model_id', 
        'old_values', 
        'new_values', 
        'ip_address', 
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a system action.
     */
    public static function log($action, $model = null, $oldValues = null, $newValues = null)
    {
        self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    public function getTranslatedActionAttribute()
    {
        $map = [
            'created' => 'Création',
            'updated' => 'Modification',
            'deleted' => 'Suppression',
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'restored' => 'Restauration',
            'approved' => 'Approuvé',
            'rejected' => 'Rejeté',
            
            // Specific User Actions
            'user_created' => 'Création d\'utilisateur',
            'user_updated' => 'Modification d\'utilisateur',
            'user_deleted' => 'Suppression d\'utilisateur',
            'delete_user' => 'Suppression d\'utilisateur',
            'user_password_reset' => 'Réinitialisation mot de passe',
            
            // Specific Opportunity Actions
            'opportunity_created' => 'Création d\'opportunité',
            'opportunity_updated' => 'Modification d\'opportunité',
            'opportunity_deleted' => 'Suppression d\'opportunité',
            'opportunity_status_change' => 'Changement de stade',
            
            // Access Requests
            'approve_access_request' => 'Validation demande accès',
            'reject_access_request' => 'Rejet demande accès',

            // Exports
            'data_export_csv' => 'Extraction CSV',
            'data_export_pdf' => 'Génération PDF',
            'gdpr_export' => 'Archive RGPD',
            'system_backup' => 'Sauvegarde Système',
        ];
        return $map[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    public function getTranslatedModelTypeAttribute()
    {
        if (!$this->model_type) return '-';
        $base = class_basename($this->model_type);
        $map = [
            'User' => 'Utilisateur',
            'Contact' => 'Contact',
            'Opportunity' => 'Opportunité',
            'Task' => 'Tâche',
            'Activity' => 'Activité',
            'AccessRequest' => 'Demande d\'accès',
            'AuditLog' => 'Log d\'Audit',
            'Notification' => 'Notification',
        ];
        return $map[$base] ?? $base;
    }

    public static function getTranslatedKey($key)
    {
        $map = [
            'id' => 'ID',
            'created_at' => 'Créé le',
            'updated_at' => 'Mis à jour le',
            'deleted_at' => 'Supprimé le',
            'email' => 'Email',
            'name' => 'Nom',
            'password' => 'Mot de passe',
            'role' => 'Rôle',
            'remember_token' => 'Jeton de rappel',
            'email_verified_at' => 'Email vérifié le',
            'avatar' => 'Avatar',
            'bio' => 'Biographie',
            
            // Contact & Opportunity fields might already be french but standardizing common ones
            'first_name' => 'Prénom',
            'last_name' => 'Nom',
            'phone' => 'Téléphone',
            'address' => 'Adresse',
            'city' => 'Ville',
            'zip' => 'Code Postal',
            'country' => 'Pays',
            'status' => 'Statut',
            'type' => 'Type',
            'description' => 'Description',
            'title' => 'Titre',
            'amount' => 'Montant',
            'stage' => 'Stade',
            'probability' => 'Probabilité',
            'user_id' => 'Utilisateur (ID)',
            'commercial_id' => 'Commercial (ID)',
            'contact_id' => 'Contact (ID)',
            'opportunity_id' => 'Opportunité (ID)',
            'assigned_to' => 'Assigné à',
            'created_by' => 'Créé par',
            
            // Specifics
            'is_admin' => 'Est Admin',
            'company' => 'Entreprise',
            'job_title' => 'Poste',
        ];

        // Return mapped value or capitalized key with underscores replaced by spaces
        return $map[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }
}
