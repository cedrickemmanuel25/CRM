<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Mon CRM',
                'type' => 'string',
                'description' => 'Nom de l\'entreprise affiché dans l\'application',
            ],
            [
                'key' => 'currency',
                'value' => 'EUR',
                'type' => 'string',
                'description' => 'Devise par défaut',
            ],
            [
                'key' => 'timezone',
                'value' => 'Europe/Paris',
                'type' => 'string',
                'description' => 'Fuseau horaire du système',
            ],
            [
                'key' => 'enable_registration',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Autoriser l\'inscription publique',
            ],
            [
                'key' => 'system_logo',
                'value' => null, // Path to logo
                'type' => 'string',
                'description' => 'Chemin du logo de l\'entreprise',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
