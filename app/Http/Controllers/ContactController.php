<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Relation Eager Loading
        $query->with('owner');

        // Sécurisation accès commercial
        if (auth()->user()->isCommercial()) {
            $query->where('user_id_owner', auth()->id());
        }

        // Search scope (nom, prenom, email, entreprise)
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtre par entreprise
        if ($request->filled('entreprise')) {
            $query->where('entreprise', 'like', "%{$request->entreprise}%");
        }

        // Filtre par source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filtre par propriétaire (Commercial assigné)
        if ($request->filled('owner_id')) {
            $query->where('user_id_owner', $request->owner_id);
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Tri (Sorting)
        $allowedSorts = ['nom', 'entreprise', 'created_at'];
        $sortBy = in_array($request->query('sort'), $allowedSorts) ? $request->query('sort') : 'created_at';
        $sortOrder = $request->query('order') === 'asc' ? 'asc' : 'desc';
        
        $query->orderBy($sortBy, $sortOrder);

        // Pagination dynamique (20 ou 50)
        $perPage = in_array($request->query('per_page'), [20, 50]) ? $request->query('per_page') : 20;
        $contacts = $query->paginate($perPage)->withQueryString();

        // Données pour les filtres
        $sources = Contact::distinct()->whereNotNull('source')->pluck('source');
        $owners = \App\Models\User::whereHas('contacts')->get();
        $entreprises = Contact::distinct()->whereNotNull('entreprise')->pluck('entreprise');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('contacts._table_rows', compact('contacts'))->render(),
                'total' => $contacts->total()
            ]);
        }

        return view('contacts.index', compact('contacts', 'sources', 'owners', 'entreprises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:contacts,email',
            'alternative_emails' => 'nullable|array',
            'alternative_emails.*' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:20',
            'alternative_telephones' => 'nullable|array',
            'alternative_telephones.*' => 'nullable|string|max:25',
            'entreprise' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:500',
            'source' => 'nullable|string|max:100',
            'poste' => 'nullable|string|max:255',
            'tags_input' => 'nullable|string',
            'statut' => 'required|in:lead,prospect,client,inactif',
            'notes_internes' => 'nullable|string',
        ]);

        // Process tags
        if ($request->filled('tags_input')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags_input));
        }

        // Cleanup empty strings in arrays
        if (isset($validated['alternative_emails'])) {
            $validated['alternative_emails'] = array_filter($validated['alternative_emails']);
        }
        if (isset($validated['alternative_telephones'])) {
            $validated['alternative_telephones'] = array_filter($validated['alternative_telephones']);
        }

        // Assigner le propriétaire (utilisateur connecté par défaut)
        $validated['user_id_owner'] = auth()->id();

        $contact = Contact::create($validated);

        // Notification d'assignation
        if ($contact->user_id_owner && $contact->user_id_owner !== auth()->id()) {
            $owner = \App\Models\User::find($contact->user_id_owner);
            if ($owner) {
                $owner->notify(new \App\Notifications\EntityAssigned(
                    'contact', 
                    $contact, 
                    auth()->user(),
                    "Un nouveau contact vous a été assigné : {$contact->prenom} {$contact->nom}"
                ));
            }
        }
        
        // Notification action globale (pour admins si besoin, ou logging)
        // Ici on notifie seulement si assignation différente

        return redirect()->route('contacts.index')
            ->with('success', 'Contact créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact, Request $request)
    {
        // Autorisation : Admin voit tout, Commercial voit seulement les siens
        if (auth()->user()->isCommercial() && $contact->user_id_owner !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce contact.');
        }

        // Chargement des relations pour la vue détaillée
        $contact->load([
            'owner',
            'opportunities' => function($query) {
                $query->latest();
            },
            'activities.user',
            'tasks.assignee',
            'tasks.creator'
        ]);
        
        // Filtrage des activités
        $activitiesQuery = $contact->activities()->with('user');

        if ($request->filled('type')) {
            $activitiesQuery->where('type', $request->type);
        }

        if ($request->filled('date_start')) {
            $activitiesQuery->whereDate('date_activite', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $activitiesQuery->whereDate('date_activite', '<=', $request->date_end);
        }

        $allActivities = $activitiesQuery->orderBy('date_activite', 'desc')->get();
        
        $tickets = $allActivities->whereIn('type', ['ticket', 'probleme', 'reclamation']);
        $notes = $allActivities->where('type', 'note');
        
        // Tasks for the specific tab
        $tasks = $contact->tasks()->with(['assignee', 'creator'])->latest()->get();
        
        // Calcul du CA potentiel (opportunités en cours)
        $potentialValue = $contact->opportunities
            ->whereNotIn('stade', ['gagne', 'perdu'])
            ->sum('montant_estime');
        
        // Détermination des droits d'édition
        $user = auth()->user();
        $canEdit = false;
        
        if ($user->isAdmin()) {
            $canEdit = true;
        } elseif ($user->isCommercial()) {
            $canEdit = $contact->user_id_owner === $user->id;
        }
        
        return view('contacts.show', compact('contact', 'potentialValue', 'tickets', 'notes', 'allActivities', 'tasks', 'canEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        // Autorisation
        if (auth()->user()->isCommercial() && $contact->user_id_owner !== auth()->id()) {
            abort(403, 'Vous n\'avez pas les droits de modification sur ce contact.');
        }

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        // Autorisation
        if (auth()->user()->isCommercial() && $contact->user_id_owner !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('contacts')->ignore($contact->id)
            ],
            'alternative_emails' => 'nullable|array',
            'alternative_emails.*' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:20',
            'alternative_telephones' => 'nullable|array',
            'alternative_telephones.*' => 'nullable|string|max:25',
            'entreprise' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:500',
            'source' => 'nullable|string|max:100',
            'poste' => 'nullable|string|max:255',
            'tags_input' => 'nullable|string',
            'statut' => 'required|in:lead,prospect,client,inactif',
            'notes_internes' => 'nullable|string',
        ]);

        // Process tags
        if ($request->filled('tags_input')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags_input));
        } else {
            $validated['tags'] = [];
        }

        // Cleanup empty strings in arrays
        if (isset($validated['alternative_emails'])) {
            $validated['alternative_emails'] = array_filter($validated['alternative_emails']);
        }
        if (isset($validated['alternative_telephones'])) {
            $validated['alternative_telephones'] = array_filter($validated['alternative_telephones']);
        }

        $contact->update($validated);

        // Notifier le propriétaire si modifié par quelqu'un d'autre
        if ($contact->user_id_owner && $contact->user_id_owner !== auth()->id()) {
             $owner = \App\Models\User::find($contact->user_id_owner);
             if ($owner) {
                 $owner->notify(new \App\Notifications\EntityActionNotification(
                     'updated',
                     $contact,
                     'contact',
                     "Votre contact {$contact->prenom} {$contact->nom} a été modifié par " . auth()->user()->name,
                     auth()->user()
                 ));
             }
        }

        return redirect()->route('contacts.show', $contact)
            ->with('success', 'Contact mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // Autorisation (seul admin peut supprimer ou le owner ?) 
        // Pour l'instant on garde la logique stricte owner ou admin
        if (auth()->user()->isCommercial() && $contact->user_id_owner !== auth()->id()) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact supprimé avec succès.');
    }

    /**
     * Ajouter une activité rapide au contact.
     */
    public function addActivity(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'type' => 'required|in:appel,email,reunion,tache',
            'description' => 'required|string',
            'date_activite' => 'required|date',
            'statut' => 'required|in:planifie,termine,annule',
        ]);

        $contact->activities()->create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'description' => $validated['description'],
            'date_activite' => $validated['date_activite'],
            'statut' => $validated['statut'],
        ]);

        return back()->with('success', 'Activité ajoutée.');
    }
    
    /**
     * Store a dedicated note for the contact.
     */
    public function storeNote(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
        ]);

        $contact->activities()->create([
            'user_id' => auth()->id(),
            'type' => 'note',
            'description' => 'Note ajoutée', // Short desc suitable for lists
            'contenu' => $validated['contenu'],
            'date_activite' => now(),
            'statut' => 'termine',
        ]);

        return back()->with('success', 'Note enregistrée.');
    }

    /**
     * Create a support ticket from the contact view.
     */
    public function storeTicket(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'sujet' => 'required|string|max:255',
            'priorite' => 'required|in:basse,normale,haute',
            'description' => 'required|string',
        ]);

        $contact->activities()->create([
            'user_id' => auth()->id(),
            'type' => 'ticket',
            'description' => $validated['sujet'], // Using description as the title/subject
            'contenu' => $validated['description'], // Full details
            'priorite' => $validated['priorite'],
            'date_activite' => now(),
            'statut' => 'nouveau', // Default status for tickets
        ]);

        return back()->with('success', 'Ticket support créé avec succès.');
    }

    /**
     * Ajouter une opportunité rapide au contact.
     */
    public function addOpportunity(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'montant_estime' => 'required|numeric|min:0',
            'stade' => 'required|in:prospection,qualification,proposition,negociation,gagne,perdu',
            'probabilite' => 'required|integer|min:0|max:100',
        ]);

        $contact->opportunities()->create([
            'user_id' => auth()->id(),
            'titre' => $validated['titre'],
            'montant_estime' => $validated['montant_estime'],
            'stade' => $validated['stade'],
            'probabilite' => $validated['probabilite'],
            'date_cloture_estimee' => now()->addMonths(1), // Défaut
        ]);

        return back()->with('success', 'Opportunité créée.');
    }

    /**
     * Exporter les données du contact.
     */
    public function export(Contact $contact)
    {
        if (auth()->user()->isCommercial() && $contact->user_id_owner !== auth()->id()) {
            abort(403);
        }

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=contact_{$contact->id}_{$contact->nom}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Nom', 'Prenom', 'Email', 'Telephone', 'Entreprise', 'Poste', 'Source', 'Statut', 'Date Creation'];

        $callback = function() use ($contact, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Use semicolon separator for European Excel compatibility
            fputcsv($file, $columns, ';');

            fputcsv($file, [
                $contact->id,
                $contact->nom,
                $contact->prenom,
                $contact->email,
                $contact->telephone,
                $contact->entreprise,
                $contact->poste,
                $contact->source,
                $contact->statut,
                $contact->created_at->format('Y-m-d H:i:s')
            ], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Convert contact to opportunity
     */
    public function convertToOpportunity(Contact $contact)
    {
        // Autorisation : Admin ou Commercial propriétaire
        if (!auth()->user()->isAdmin() && $contact->user_id_owner !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à convertir ce contact.');
        }

        // Création de l'opportunité
        $opportunity = \App\Models\Opportunity::create([
            'commercial_id' => $contact->user_id_owner ?? auth()->id(),
            'contact_id'    => $contact->id,
            'titre'         => 'Opportunité : ' . $contact->nom . ' ' . $contact->prenom,
            'stade'         => 'prospection',
            'probabilite'   => 10,
            'montant_estime'=> 0,
            'statut'        => 'actif',
        ]);

        // Mise à jour du statut du contact si c'était un lead
        if ($contact->statut === 'lead') {
            $contact->update(['statut' => 'prospect']);
        }

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Contact converti en opportunité avec succès.');
    }
}
