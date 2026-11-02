<?php

namespace Database\Seeders;

use App\Models\AccessRequest;
use App\Models\Activity;
use App\Models\AttributionRule;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\OpportunityAttributionHistory;
use App\Models\OpportunityHistory;
use App\Models\Setting;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\EntityActionNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Jeu de données de démonstration entièrement fictif (portfolio / captures d'écran).
 *
 * Usage : php artisan migrate:fresh --seed --seeder=DemoSeeder
 * Tous les comptes utilisent le mot de passe "Demo@1234" et le domaine réservé example.com.
 */
class DemoSeeder extends Seeder
{
    public const PASSWORD = 'Demo@1234';

    public function run(): void
    {
        $this->call([SettingsSeeder::class, NotificationSeeder::class]);

        Setting::set('company_name', 'Horizon CRM');
        Setting::set('currency', 'EUR');

        // Les observateurs / événements génèrent des journaux d'audit et des notifications
        // horodatés « maintenant » : on les coupe pendant la génération de l'historique.
        Model::withoutEvents(function () {
            $users = $this->seedUsers();
            $contacts = $this->seedContacts($users);
            $opportunities = $this->seedOpportunities($users, $contacts);
            $this->seedActivities($users, $contacts, $opportunities);
            $this->seedTasks($users, $contacts, $opportunities);
            $this->seedTickets($users, $contacts);
            $this->seedAttributionRules($users);
            $this->seedAccessRequests();
            $this->seedNotifications($users, $opportunities);
        });

        $this->syncContactStatuses();

        $this->command?->info('Données de démonstration créées. Mot de passe des comptes : ' . self::PASSWORD);
    }

    private function seedUsers(): array
    {
        $definitions = [
            'admin' => ['Claire Martin', 'admin@example.com', 'admin'],
            'commercial' => ['Hugo Bernard', 'commercial@example.com', 'commercial'],
            'commercial2' => ['Inès Moreau', 'ines.moreau@example.com', 'commercial'],
            'commercial3' => ['Yann Kouassi', 'yann.kouassi@example.com', 'commercial'],
            'support' => ['Sarah Lefèvre', 'support@example.com', 'support'],
            'visitor' => ['Paul Visiteur', 'visiteur@example.com', 'visitor'],
        ];

        $users = [];
        foreach ($definitions as $key => [$name, $email, $role]) {
            $users[$key] = User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make(self::PASSWORD),
                'role' => $role,
                'telephone' => '+33 1 00 00 00 ' . str_pad((string) (count($users) + 10), 2, '0', STR_PAD_LEFT),
                'email_verified_at' => now(),
            ]);
            $this->backdate($users[$key], now()->subMonths(7)->addDays(count($users) * 3));
        }

        return $users;
    }

    private function seedContacts(array $users): array
    {
        $owners = [$users['commercial'], $users['commercial2'], $users['commercial3'], $users['admin']];
        $sources = ['LinkedIn', 'Site Web', 'Recommandation', 'Emailing', 'Événement'];

        $rows = [
            ['Durand', 'Élise', 'Atelier Boréal', 'Directrice générale'],
            ['Lambert', 'Thomas', 'Nexa Logistique', 'Responsable achats'],
            ['Petit', 'Camille', 'Studio Lumen', 'Directrice marketing'],
            ['Roux', 'Antoine', 'Verdi Énergies', 'DSI'],
            ['Fontaine', 'Julie', 'Cabinet Altis', 'Associée'],
            ['Chevalier', 'Marc', 'Orbis Distribution', 'Directeur commercial'],
            ['Girard', 'Nadia', 'Helios Santé', 'Office manager'],
            ['Faure', 'Léo', 'Kappa Industries', 'Responsable production'],
            ['Mercier', 'Sophie', 'Agence Cobalt', 'Fondatrice'],
            ['Blanc', 'Karim', 'Transports Méridien', 'Gérant'],
            ['Guerin', 'Laura', 'Pixel & Co', 'Cheffe de projet'],
            ['Boyer', 'Damien', 'Équinoxe Immobilier', 'Directeur'],
            ['Diallo', 'Aïssata', 'Savane Agro', 'Responsable export'],
            ['Konan', 'Serge', 'Lagune Telecom', 'Directeur technique'],
            ['Andre', 'Manon', 'Optima Conseil', 'Consultante senior'],
            ['Colin', 'Bastien', 'Cimes Outdoor', 'Responsable e-commerce'],
            ['Perrin', 'Chloé', 'BioNova Labs', 'Directrice R&D'],
            ['Morel', 'Julien', 'Arcadia Hôtels', 'Directeur des opérations'],
            ['Traoré', 'Moussa', 'Sahel BTP', 'Directeur financier'],
            ['Vidal', 'Emma', 'Lettres & Papiers', 'Gérante'],
            ['Renaud', 'Hugo', 'Quartz Software', 'CTO'],
            ['Gauthier', 'Inès', 'Maison Ondine', 'Responsable boutique'],
        ];

        $contacts = [];
        foreach ($rows as $i => [$nom, $prenom, $entreprise, $poste]) {
            $slug = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $prenom . '.' . $nom));
            $contact = Contact::create([
                'user_id_owner' => $owners[$i % count($owners)]->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => preg_replace('/[^a-z.]/', '', $slug) . '@example.com',
                'telephone' => '+33 6 00 00 ' . str_pad((string) (10 + $i), 2, '0', STR_PAD_LEFT) . ' ' . str_pad((string) (20 + $i), 2, '0', STR_PAD_LEFT),
                'entreprise' => $entreprise,
                'adresse' => (10 + $i) . ' rue de l\'Exemple, 75000 Paris',
                'source' => $sources[$i % count($sources)],
                'poste' => $poste,
                'tags' => $i % 3 === 0 ? ['Grand compte'] : ($i % 3 === 1 ? ['PME'] : ['Startup']),
                'statut' => 'nouveau',
                'notes_internes' => 'Contact fictif généré pour la démonstration.',
            ]);
            // Les 3 derniers contacts sont créés récemment pour alimenter la tendance des leads.
            $created = $i >= count($rows) - 3
                ? now()->subDays(count($rows) - 1 - $i)->setTime(10, 15)
                : now()->subDays(170 - $i * 7)->setTime(9 + $i % 8, 30);
            $this->backdate($contact, $created);
            $contacts[] = $contact;
        }

        return $contacts;
    }

    private function seedOpportunities(array $users, array $contacts): array
    {
        $plan = [
            // [contact index, titre, montant, stade, mois avant aujourd'hui (création), clôture prévue en jours]
            [0, 'Refonte du site vitrine', 18500, 'gagne', 5, -120],
            [1, 'Logiciel de suivi de flotte', 42000, 'negociation', 2, 20],
            [2, 'Campagne d\'acquisition digitale', 9800, 'proposition', 1, 35],
            [3, 'Migration ERP – phase 1', 65000, 'qualification', 1, 75],
            [4, 'Audit organisationnel', 12000, 'gagne', 4, -80],
            [5, 'Portail distributeurs B2B', 38000, 'proposition', 2, 30],
            [6, 'Équipement salle de réunion', 7400, 'perdu', 3, -60],
            [7, 'Maintenance préventive annuelle', 23000, 'gagne', 3, -45],
            [8, 'Identité visuelle complète', 6200, 'prospection', 0, 60],
            [9, 'Optimisation des tournées', 27500, 'negociation', 1, 15],
            [10, 'Application mobile client', 54000, 'qualification', 0, 90],
            [11, 'CRM immobilier sur mesure', 31000, 'gagne', 2, -20],
            [12, 'Plateforme de traçabilité export', 47000, 'proposition', 1, 40],
            [13, 'Supervision réseau 24/7', 29000, 'gagne', 1, -10],
            [14, 'Mission d\'accompagnement RH', 8800, 'perdu', 2, -30],
            [15, 'Boutique en ligne v2', 21000, 'prospection', 0, 70],
            [16, 'LIMS – gestion de laboratoire', 72000, 'negociation', 2, 25],
            [17, 'Système de réservation', 16500, 'gagne', 0, -3],
            [18, 'Suivi de chantiers', 39000, 'qualification', 0, 55],
            [19, 'Site e-commerce papeterie', 5400, 'prospection', 0, 45],
        ];

        $probabilities = ['prospection' => 10, 'qualification' => 30, 'proposition' => 60, 'negociation' => 80, 'gagne' => 100, 'perdu' => 0];
        $opportunities = [];

        foreach ($plan as [$ci, $titre, $montant, $stade, $monthsAgo, $closeIn]) {
            $contact = $contacts[$ci];
            $created = now()->subMonths($monthsAgo)->subDays(($ci * 3) % 20)->setTime(11, 0);
            if ($created->isFuture()) {
                $created = now()->subDays(2);
            }

            $opportunity = Opportunity::create([
                'commercial_id' => $contact->user_id_owner,
                'contact_id' => $contact->id,
                'titre' => $titre,
                'description' => 'Opportunité fictive de démonstration.',
                'montant_estime' => $montant,
                'stade' => $stade,
                'probabilite' => $probabilities[$stade],
                'date_cloture_prev' => now()->addDays($closeIn)->toDateString(),
                'statut' => 'actif',
                'attribution_mode' => 'manual',
                'assigned_at' => $created,
                'besoin' => in_array($stade, ['prospection']) ? null : 'Besoin qualifié lors des premiers échanges.',
                'niveau_interet' => in_array($stade, ['prospection']) ? null : 'eleve',
                'motif_perte' => $stade === 'perdu' ? 'budget' : null,
            ]);

            // Les affaires clôturées sont « mises à jour » à leur date de clôture (utilisé par les graphiques de CA).
            $updated = in_array($stade, ['gagne', 'perdu'])
                ? Carbon::parse($opportunity->date_cloture_prev)->setTime(16, 0)
                : $created->copy()->addDays(5);
            if ($updated->isFuture()) {
                $updated = now()->subHours(3);
            }
            $this->backdate($opportunity, $created, $updated);

            OpportunityAttributionHistory::create([
                'opportunity_id' => $opportunity->id,
                'assigned_to' => $opportunity->commercial_id,
                'assigned_by' => $users['admin']->id,
                'mode' => 'manual',
                'reason' => 'Création de l\'opportunité',
            ]);

            if ($stade !== 'prospection') {
                OpportunityHistory::create([
                    'opportunity_id' => $opportunity->id,
                    'user_id' => $opportunity->commercial_id,
                    'old_stage' => 'prospection',
                    'new_stage' => $stade,
                    'changed_at' => $updated,
                ]);
            }

            $opportunities[] = $opportunity;
        }

        return $opportunities;
    }

    private function seedActivities(array $users, array $contacts, array $opportunities): void
    {
        $entries = [
            ['appel', 'Appel de découverte : besoins et calendrier', -1, 'termine'],
            ['email', 'Envoi de la proposition commerciale', -2, 'termine'],
            ['reunion', 'Démonstration produit en visioconférence', 2, 'planifie'],
            ['note', 'Le client souhaite un phasage du projet en deux lots', -3, 'termine'],
            ['appel', 'Relance après réception du devis', -4, 'termine'],
            ['reunion', 'Atelier de cadrage avec l\'équipe technique', 4, 'planifie'],
            ['email', 'Partage du compte rendu de réunion', -6, 'termine'],
            ['appel', 'Point d\'avancement mensuel', 1, 'planifie'],
        ];

        foreach ($entries as $i => [$type, $description, $dayOffset, $statut]) {
            $contact = $contacts[$i * 2 % count($contacts)];
            $activity = Activity::create([
                'user_id' => $contact->user_id_owner,
                'parent_type' => 'contact',
                'parent_id' => $contact->id,
                'type' => $type,
                'description' => $description,
                'date_activite' => now()->addDays($dayOffset)->setTime(10 + $i % 6, 0),
                'statut' => $statut,
                'duree' => 30,
            ]);
            $this->backdate($activity, now()->subDays(abs($dayOffset) + 1));
        }

        foreach (array_slice($opportunities, 0, 6) as $i => $opportunity) {
            $activity = Activity::create([
                'user_id' => $opportunity->commercial_id,
                'parent_type' => 'opportunity',
                'parent_id' => $opportunity->id,
                'type' => $i % 2 ? 'email' : 'appel',
                'description' => $i % 2 ? 'Envoi des conditions tarifaires' : 'Échange sur le périmètre du projet',
                'date_activite' => now()->subDays($i + 1)->setTime(14, 0),
                'statut' => 'termine',
            ]);
            $this->backdate($activity, now()->subDays($i + 1));
        }
    }

    private function seedTasks(array $users, array $contacts, array $opportunities): void
    {
        $tasks = [
            ['Relancer Nexa Logistique sur la négociation', 'commercial', -2, 'todo', 'high', $opportunities[1]],
            ['Préparer la démo pour Studio Lumen', 'commercial3', 0, 'in_progress', 'high', $contacts[2]],
            ['Envoyer le contrat signé à Atelier Boréal', 'commercial', -5, 'done', 'medium', $contacts[0]],
            ['Qualifier le besoin ERP de Verdi Énergies', 'commercial', 3, 'todo', 'medium', $opportunities[3]],
            ['Mettre à jour la grille tarifaire 2027', 'admin', 6, 'todo', 'low', null],
            ['Planifier le point mensuel avec Orbis', 'commercial2', 1, 'todo', 'medium', $contacts[5]],
            ['Répondre au ticket de facturation Helios', 'support', 0, 'in_progress', 'high', $contacts[6]],
            ['Vérifier la configuration réseau Lagune Telecom', 'support', 2, 'todo', 'medium', $contacts[13]],
            ['Préparer la revue du pipeline trimestriel', 'admin', -1, 'todo', 'high', null],
            ['Envoyer la proposition BioNova Labs', 'commercial2', 4, 'todo', 'high', $opportunities[16]],
            ['Archiver les affaires perdues du trimestre', 'admin', -10, 'done', 'low', null],
        ];

        foreach ($tasks as $i => [$titre, $assignee, $dayOffset, $statut, $priority, $related]) {
            $task = Task::create([
                'titre' => $titre,
                'description' => 'Tâche fictive de démonstration.',
                'assigned_to' => $users[$assignee]->id,
                'created_by' => $users['admin']->id,
                'due_date' => now()->addDays($dayOffset)->setTime(9 + $i % 8, 0),
                'statut' => $statut,
                'priority' => $priority,
                'related_type' => $related ? $related->getMorphClass() : null,
                'related_id' => $related?->id,
            ]);
            $this->backdate($task, now()->subDays(max(1, abs($dayOffset)) + 3));
        }
    }

    private function seedTickets(array $users, array $contacts): void
    {
        $tickets = [
            ['Erreur 500 à l\'export des factures', 'technical', 'urgent', 'in_progress', 6, 0],
            ['Demande de duplicata de facture', 'billing', 'medium', 'new', 11, 0],
            ['Accès utilisateur bloqué', 'technical', 'high', 'new', 13, 1],
            ['Ajout d\'un champ « SIRET » sur la fiche client', 'feature_request', 'low', 'waiting_client', 2, 3],
            ['Question sur le renouvellement du contrat', 'commercial', 'medium', 'resolved', 0, 5],
            ['Lenteurs sur le tableau de bord', 'technical', 'high', 'resolved', 17, 2],
            ['Changement d\'adresse de facturation', 'billing', 'low', 'closed', 4, 9],
        ];

        foreach ($tickets as [$subject, $category, $priority, $status, $ci, $daysAgo]) {
            $ticket = Ticket::create([
                'subject' => $subject,
                'description' => 'Ticket fictif de démonstration : ' . mb_strtolower($subject) . '.',
                'category' => $category,
                'priority' => $priority,
                'status' => $status,
                'contact_id' => $contacts[$ci]->id,
                'user_id' => $users['support']->id,
                'assigned_to' => $status === 'new' && $priority === 'medium' ? null : $users['support']->id,
            ]);
            $this->backdate($ticket, now()->subDays($daysAgo + 1)->setTime(9, 0), now()->subDays($daysAgo)->setTime(15, 0));

            if ($status !== 'new') {
                $ticket->activities()->create([
                    'user_id' => $users['support']->id,
                    'type' => 'interaction',
                    'description' => 'Réponse au ticket',
                    'contenu' => 'Bonjour, nous avons bien pris en compte votre demande et revenons vers vous rapidement.',
                    'date_activite' => now()->subDays($daysAgo)->setTime(11, 0),
                    'statut' => 'termine',
                ]);
            }
        }
    }

    private function seedAttributionRules(array $users): void
    {
        AttributionRule::create(['name' => 'Leads LinkedIn → Hugo', 'criteria_type' => 'source', 'criteria_value' => 'LinkedIn', 'target_user_id' => $users['commercial']->id, 'priority' => 10, 'is_active' => true]);
        AttributionRule::create(['name' => 'Grands comptes (> 50 000 €)', 'criteria_type' => 'amount_gt', 'criteria_value' => '50000', 'target_user_id' => $users['commercial2']->id, 'priority' => 20, 'is_active' => true]);
        AttributionRule::create(['name' => 'Répartition par charge', 'criteria_type' => 'workload', 'criteria_value' => null, 'target_user_id' => null, 'priority' => 1, 'is_active' => true]);
    }

    private function seedAccessRequests(): void
    {
        AccessRequest::create(['nom' => 'Lemoine', 'prenom' => 'Arthur', 'email' => 'arthur.lemoine@example.com', 'telephone' => '+33 6 00 00 99 01', 'role' => 'commercial', 'status' => 'pending']);
        AccessRequest::create(['nom' => 'Bakayoko', 'prenom' => 'Fatou', 'email' => 'fatou.bakayoko@example.com', 'telephone' => '+33 6 00 00 99 02', 'role' => 'support', 'status' => 'pending']);
    }

    private function seedNotifications(array $users, array $opportunities): void
    {
        $users['admin']->notify(new EntityActionNotification('updated', $opportunities[17], 'opportunity', 'Opportunité gagnée : « Système de réservation »', $users['commercial2']));
        $users['admin']->notify(new EntityActionNotification('created', $opportunities[19], 'opportunity', 'Nouvelle opportunité : « Site e-commerce papeterie »', $users['commercial3']));
        $users['commercial']->notify(new EntityActionNotification('updated', $opportunities[1], 'opportunity', 'Vous avez été assigné à « Logiciel de suivi de flotte »', $users['admin']));
    }

    /**
     * Aligne le statut pipeline des contacts sur leurs opportunités (même règle que OpportunityObserver).
     */
    private function syncContactStatuses(): void
    {
        $mapping = ['prospection' => 'nouveau', 'qualification' => 'qualifie', 'proposition' => 'proposition', 'negociation' => 'negociation', 'gagne' => 'client', 'perdu' => 'perdu'];
        $precedence = ['gagne', 'negociation', 'proposition', 'qualification', 'prospection', 'perdu'];

        Contact::with('opportunities')->get()->each(function (Contact $contact) use ($mapping, $precedence) {
            if ($contact->opportunities->isEmpty()) {
                return;
            }
            $best = collect($precedence)->first(fn ($stage) => $contact->opportunities->contains('stade', $stage));
            DB::table('contacts')->where('id', $contact->id)->update(['statut' => $mapping[$best]]);
        });
    }

    private function backdate(Model $model, Carbon $created, ?Carbon $updated = null): void
    {
        DB::table($model->getTable())->where('id', $model->getKey())->update([
            'created_at' => $created,
            'updated_at' => $updated ?? $created,
        ]);
    }
}
