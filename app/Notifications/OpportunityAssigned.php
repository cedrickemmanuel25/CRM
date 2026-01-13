<?php

namespace App\Notifications;

use App\Models\Opportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityAssigned extends Notification
{
    use Queueable;

    protected $opportunity;

    public function __construct(Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    public function via($notifiable): array
    {
        return ['database']; // Keeping it simple with database notifications as requested/common
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'opportunity_assigned',
            'opportunity_id' => $this->opportunity->id,
            'titre' => $this->opportunity->titre,
            'message' => "L'opportunité \"{$this->opportunity->titre}\" vous a été assignée.",
            'url' => route('opportunities.show', $this->opportunity),
        ];
    }
}
