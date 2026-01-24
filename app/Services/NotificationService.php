<?php

namespace App\Services;

use App\Models\NotificationPreference;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send notification to eligible users based on preferences.
     * 
     * @param string $eventType e.g., 'contact_created'
     * @param mixed $notification Notification instance
     */
    public static function send($eventType, $notification)
    {
        // 1. Get global preference
        $globalPref = NotificationPreference::whereNull('user_id')
            ->where('event_type', $eventType)
            ->first();

        // If global is completely disabled for both, stop here
        if ($globalPref && !$globalPref->email_enabled && !$globalPref->push_enabled) {
            return;
        }

        // 2. Identify target users (Admins by default for system changes)
        // In a real app, you might want to notify only the owner, etc.
        // For now, let's notify all admins if the global setting allows it.
        $users = User::admins()->get();

        foreach ($users as $user) {
            // Check for user-specific override (Planned but not yet implemented in UI)
            $userPref = NotificationPreference::where('user_id', $user->id)
                ->where('event_type', $eventType)
                ->first();

            $pref = $userPref ?? $globalPref;

            if (!$pref) continue;

            $channels = [];
            if ($pref->email_enabled) $channels[] = 'mail';
            if ($pref->push_enabled) $channels[] = 'database';

            if (!empty($channels)) {
                // We use a custom notification wrapper to force channels
                $user->notify(new class($notification, $channels) extends \Illuminate\Notifications\Notification {
                    protected $inner;
                    protected $channels;
                    public function __construct($inner, $channels) {
                        $this->inner = $inner;
                        $this->channels = $channels;
                    }
                    public function via($notifiable) { return $this->channels; }
                    public function toMail($notifiable) { return $this->inner->toMail($notifiable); }
                    public function toArray($notifiable) { return $this->inner->toArray($notifiable); }
                });
            }
        }
    }
}
