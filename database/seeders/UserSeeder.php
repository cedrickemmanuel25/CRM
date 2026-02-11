<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si un admin existe déjà
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'guehiphilippe@ya-consulting.com',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'telephone' => '+33 1 23 45 67 89',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Utilisateur admin créé avec succès');
            $this->command->warn('Email: guehiphilippe@ya-consulting.com');
            $this->command->warn('Mot de passe: Admin@123');
            $this->command->error('⚠ IMPORTANT: Changez ces identifiants en production!');
        } else {
            $this->command->info('Un administrateur existe déjà. Aucun utilisateur créé.');
        }

        // Optionnel: Créer des utilisateurs de test pour les autres rôles
        if (app()->environment('local')) {
            // Commercial de test
            if (!User::where('email', 'courriel+commercial@ya-consulting.com')->exists()) {
                User::create([
                    'name' => 'Commercial Test',
                    'email' => 'courriel+commercial@ya-consulting.com',
                    'password' => Hash::make('Commercial@123'),
                    'role' => 'commercial',
                    'telephone' => '+33 1 23 45 67 90',
                    'email_verified_at' => now(),
                ]);
                $this->command->info('✓ Utilisateur commercial créé (environnement local)');
            }

            // Support de test
            if (!User::where('email', 'courriel+support@ya-consulting.com')->exists()) {
                User::create([
                    'name' => 'Support Test',
                    'email' => 'courriel+support@ya-consulting.com',
                    'password' => Hash::make('Support@123'),
                    'role' => 'support',
                    'telephone' => '+33 1 23 45 67 91',
                    'email_verified_at' => now(),
                ]);
                $this->command->info('✓ Utilisateur support créé (environnement local)');
            }

            // Visiteur de test
            if (!User::where('email', 'courriel+visitor@ya-consulting.com')->exists()) {
                User::create([
                    'name' => 'Visiteur Test',
                    'email' => 'courriel+visitor@ya-consulting.com',
                    'password' => Hash::make('Visitor@123'),
                    'role' => 'visitor',
                    'telephone' => '+33 1 23 45 67 92',
                    'email_verified_at' => now(),
                ]);
                $this->command->info('✓ Utilisateur visiteur créé (environnement local)');
            }
        }
    }
}
