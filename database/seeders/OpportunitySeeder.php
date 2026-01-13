<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;
use App\Models\Opportunity;
use Carbon\Carbon;

class OpportunitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $commercial = User::where('role', 'commercial')->first();
        $contacts = Contact::all();

        if ($contacts->isEmpty()) {
            $this->command->warn('Aucun contact trouvé. Lancez ContactSeeder d\'abord.');
            return;
        }

        $stages = ['prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu'];

        // Créer 15 opportunités
        for ($i = 0; $i < 15; $i++) {
            $stade = $stages[array_rand($stages)];
            $probabilite = match($stade) {
                'prospection' => 10,
                'qualification' => 30,
                'proposition' => 60,
                'negociation' => 80,
                'gagne' => 100,
                'perdu' => 0,
            };

            Opportunity::create([
                'commercial_id' => ($i % 2 == 0) ? $admin->id : $commercial->id,
                'contact_id' => $contacts->random()->id,
                'titre' => 'Opportunité #' . ($i + 1) . ' - ' . ($i % 2 == 0 ? 'Service A' : 'Produit B'),
                'description' => 'Description générée automatiquement pour le test.',
                'montant_estime' => rand(1000, 50000),
                'stade' => $stade,
                'probabilite' => $probabilite,
                'date_cloture_prev' => Carbon::now()->addDays(rand(10, 90)),
                'statut' => 'actif',
            ]);
        }
        
        $this->command->info('15 opportunités de test créées.');
    }
}
