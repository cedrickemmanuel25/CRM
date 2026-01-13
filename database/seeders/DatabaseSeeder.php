<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // ContactSeeder (déjà appelé implicitement ou à ajouter si besoin)
            DashboardSeeder::class, // Pour les data de base
            OpportunitySeeder::class,
        ]);
    }
}
