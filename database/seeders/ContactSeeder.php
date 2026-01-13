<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        // Création de 10 contacts de test
        $sources = ['web', 'linkedin', 'referral', 'event'];
        $statuts = ['lead', 'prospect', 'client', 'inactif'];

        for ($i = 1; $i <= 10; $i++) {
            Contact::create([
                'user_id_owner' => $admin ? $admin->id : 1, // Fallback safe
                'nom' => "Nomtest$i",
                'prenom' => "Prenom$i",
                'email' => "contact$i@example.com",
                'telephone' => "+3361234567$i",
                'entreprise' => "Entreprise $i",
                'adresse' => "$i Rue de l'Exemple, 75000 Paris",
                'source' => $sources[array_rand($sources)],
                'statut' => $statuts[array_rand($statuts)],
                'poste' => 'Directeur',
            ]);
        }
    }
}
