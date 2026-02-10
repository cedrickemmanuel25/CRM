<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PerformanceSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📊 Rapport de Performance Commerciale')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Voici un résumé des performances commerciales de la période :')
            ->line('• Revenu Total : ' . number_format($this->stats['total_revenue'] ?? 0, 0, ',', ' ') . ' FCFA')
            ->line('• Opportunités Gagnées : ' . ($this->stats['opportunities_won'] ?? 0))
            ->line('• Nouveau Prospects : ' . ($this->stats['new_leads'] ?? 0))
            ->action('Voir les Rapports', url('/reports'))
            ->line('Merci de superviser l\'activité de Nexus CRM !');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'performance_summary',
            'entity' => 'report',
            'title' => 'Rapport de Performance',
            'message' => "Le revenu total s'élève à " . number_format($this->stats['total_revenue'] ?? 0, 0, ',', ' ') . " FCFA avec " . ($this->stats['opportunities_won'] ?? 0) . " ventes.",
            'link' => '/reports',
            'stats' => $this->stats
        ];
    }
}
