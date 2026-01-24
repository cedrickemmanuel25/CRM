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
    public static function send($eventType, $notification, $entity = null)
    {
        // 1. Determine base group: Admins always get system hooks
        $targetUsers = User::admins()->get();

        // 2. Add entity-specific users
        if ($entity) {
            // Add owner if exists (for Contacts/Opportunities)
            if (isset($entity->user_id_owner)) {
                $owner = User::find($entity->user_id_owner);
                if ($owner) $targetUsers->push($owner);
            }
            if (isset($entity->commercial_id)) {
                $commercial = User::find($entity->commercial_id);
                if ($commercial) $targetUsers->push($commercial);
            }
            if (isset($entity->assigned_to)) {
                $assigned = User::find($entity->assigned_to);
                if ($assigned) $targetUsers->push($assigned);
            }
        }

        // Unique users list
        $targetUsers = $targetUsers->unique('id');

        // 3. Get global preference
        $globalPref = NotificationPreference::whereNull('user_id')
            ->where('event_type', $eventType)
            ->first();

        foreach ($targetUsers as $user) {
            // 4. Check for user-specific override
            $userPref = NotificationPreference::where('user_id', $user->id)
                ->where('event_type', $eventType)
                ->first();

            $pref = $userPref ?? $globalPref;

            // If no pref AND it's not a critical system notification, we might skip
            // But with seeder, $globalPref should exist.
            if (!$pref) continue;

            $channels = [];
            if ($pref->push_enabled) $channels[] = 'database';
            if ($pref->email_enabled) $channels[] = 'mail';

            if (!empty($channels)) {
                $user->notify(new class($notification, $channels) extends \Illuminate\Notifications\Notification {
                    protected $inner;
                    protected $channels;
                    public function __construct($inner, $channels) {
                        $this->inner = $inner;
                        $this->channels = $channels;
                    }
                    public function via($notifiable) { return $this->channels; }
                    public function toMail($notifiable) { return method_exists($this->inner, 'toMail') ? $this->inner->toMail($notifiable) : null; }
                    public function toArray($notifiable) { return $this->inner->toArray($notifiable); }
                });
            }
        }
    }
}
