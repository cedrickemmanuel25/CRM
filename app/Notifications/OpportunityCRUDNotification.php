<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityCRUDNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type; // 'created', 'updated', 'won', 'lost'
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = match($this->type) {
            'created' => "Nouvelle Opportunité : {$this->data['titre']}",
            'updated' => "Opportunité Modifiée : {$this->data['titre']}",
            'won' => "Opportunité GAGNÉE ! 🎉 : {$this->data['titre']}",
            'lost' => "Opportunité Perdue : {$this->data['titre']}",
        };

        $message = (new MailMessage)
                    ->subject($title)
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line($title);

        if (isset($this->data['montant'])) {
            $message->line("Montant : " . number_format($this->data['montant'], 0, ',', ' ') . " FCFA");
        }

        return $message->action('Voir l\'opportunité', url($this->data['link'] ?? '/'))
                    ->line('Bonne chance pour cette vente !');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => "opportunity_{$this->type}",
            'entity' => 'opportunity',
            'title' => match($this->type) {
                'created' => 'Nouvelle Opportunité',
                'updated' => 'Opportunité Modifiée',
                'won' => 'Opportunité GAGNÉE ! 🏆',
                'lost' => 'Opportunité Perdue',
            },
            'titre' => $this->data['titre'],
            'message' => match($this->type) {
                'created' => "Une nouvelle opportunité \"{$this->data['titre']}\" vous attend.",
                'updated' => "L'opportunité \"{$this->data['titre']}\" a de nouvelles informations.",
                'won' => "Félicitations ! Vous avez gagné l'opportunité \"{$this->data['titre']}\".",
                'lost' => "L'opportunité \"{$this->data['titre']}\" est passée en perdu.",
            },
            'link' => $this->data['link'] ?? null,
            'amount' => $this->data['montant'] ?? null,
        ];
    }
}
