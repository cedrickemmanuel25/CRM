<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $actionType;
    protected $details;

    public function __construct($actionType, $details)
    {
        $this->actionType = $actionType;
        $this->details = $details;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $titles = [
            'user_deleted' => 'Utilisateur Supprimé',
            'export_triggered' => 'Export de Données',
            'role_changed' => 'Changement de Rôle',
            'sensitive_delete' => 'Suppression Sensible'
        ];

        return [
            'type' => 'user_activity',
            'entity' => 'security',
            'title' => $titles[$this->actionType] ?? 'Activité Utilisateur',
            'message' => $this->details['message'] ?? 'Une action administrative a été effectuée.',
            'link' => $this->details['link'] ?? '/admin/audit-logs',
            'action_type' => $this->actionType
        ];
    }
}
