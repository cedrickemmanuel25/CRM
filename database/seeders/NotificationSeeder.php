<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationPreference;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            'contact_created',
            'contact_updated',
            'contact_deleted',
            'opportunity_created',
            'opportunity_updated',
            'opportunity_won',
            'opportunity_lost',
            'task_created',
            'task_completed',
            'task_overdue',
        ];

        foreach ($eventTypes as $type) {
            NotificationPreference::updateOrCreate(
                ['user_id' => null, 'event_type' => $type],
                [
                    'email_enabled' => true,
                    'push_enabled' => true,
                ]
            );
        }
    }
}
