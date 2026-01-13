<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Activity;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les utilisateurs
        $admin = User::where('role', 'admin')->first();
        $commercial = User::where('role', 'commercial')->first();
        // S'assurer qu'ils existent (au cas où on lance sans le UserSeeder précédent, mais on suppose qu'ils sont là)
        if (!$admin || !$commercial) {
            $this->command->warn("Merci de lancer UserSeeder d'abord.");
            return;
        }

        // Créer des contacts
        $c1 = Contact::create([
            'user_id_owner' => $admin->id,
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@example.com',
            'entreprise' => 'Acme Corp',
            'statut' => 'prospect',
            'source' => 'web',
        ]);

        $c2 = Contact::create([
            'user_id_owner' => $commercial->id,
            'nom' => 'Martin',
            'prenom' => 'Sophie',
            'email' => 'sophie.martin@example.com',
            'entreprise' => 'Tech Solutions',
            'statut' => 'client',
            'source' => 'linkedin',
        ]);

        // Créer des opportunités
        // Créer des opportunités
        Opportunity::create([
            'commercial_id' => $admin->id,
            'contact_id' => $c1->id,
            'titre' => 'Contrat annuel Acme',
            'montant_estime' => 50000.00,
            'stade' => 'negociation',
            'probabilite' => 70,
            'date_cloture_prev' => Carbon::now()->addDays(15),
            'statut' => 'actif',
        ]);

        Opportunity::create([
            'commercial_id' => $commercial->id,
            'contact_id' => $c2->id,
            'titre' => 'Renouvellement Tech',
            'montant_estime' => 15000.00,
            'stade' => 'gagne',
            'probabilite' => 100,
            'date_cloture_prev' => Carbon::now()->subDays(2),
            'statut' => 'actif',
        ]);

        Opportunity::create([
            'commercial_id' => $commercial->id,
            'contact_id' => $c2->id,
            'titre' => 'Upsell Service',
            'montant_estime' => 5000.00,
            'stade' => 'proposition',
            'probabilite' => 40,
            'date_cloture_prev' => Carbon::now()->addDays(30),
            'statut' => 'actif',
        ]);

        // Créer des activités
        Activity::create([
            'parent_type' => \App\Models\Contact::class,
            'parent_id' => $c1->id,
            'user_id' => $admin->id,
            'type' => 'appel',
            'description' => 'Appel de qualification',
            'date_activite' => Carbon::now()->subHours(2),
            'statut' => 'termine',
        ]);

        Activity::create([
            'parent_type' => \App\Models\Contact::class,
            'parent_id' => $c2->id,
            'user_id' => $commercial->id,
            'type' => 'email',
            'description' => 'Envoi proposition',
            'date_activite' => Carbon::now()->subDay(),
            'statut' => 'termine',
        ]);

        // TEST : Ajouter un Lead pour Admin
        Contact::create([
            'user_id_owner' => $admin->id,
            'nom' => 'Leadrich',
            'prenom' => 'Paul',
            'email' => 'paul.leadrich@example.com',
            'entreprise' => 'New Biz',
            'statut' => 'lead',
            'source' => 'referral',
        ]);

        // TEST : Ajouter une Tâche en retard pour Admin
        Activity::create([
            'user_id' => $admin->id,
            'parent_type' => \App\Models\Contact::class,
            'parent_id' => $c1->id,
            'type' => 'tache',
            'description' => 'Relancer client (URGENT)',
            'date_activite' => Carbon::now()->subDays(3), // En retard de 3 jours
            'statut' => 'planifie',
        ]);
        
        $this->command->info('Données Dashboard créées !');
    }
}
