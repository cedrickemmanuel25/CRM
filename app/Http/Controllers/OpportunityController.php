<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    protected $attributionService;

    public function __construct(\App\Services\AttributionService $attributionService)
    {
        $this->attributionService = $attributionService;
    }

    /**
     * Affiche la liste et le pipeline des opportunités.
     */
    public function index(Request $request)
    {
        $query = Opportunity::query()->with(['commercial', 'contact']);

        // Filtres
        if ($request->filled('stade')) {
            $query->byStage($request->stade);
        }
        if ($request->filled('commercial_id')) {
            $query->byCommercial($request->commercial_id);
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('date_cloture_prev', '>=', $request->date_debut);
        }
        
        // Advanced Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhereHas('contact', function($qContact) use ($search) {
                      $qContact->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%")
                               ->orWhere('entreprise', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('amount_min')) {
            $query->where('montant_estime', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('montant_estime', '<=', $request->amount_max);
        }

        if ($request->filled('date_close_start')) {
            $query->whereDate('date_cloture_prev', '>=', $request->date_close_start);
        }
        if ($request->filled('date_close_end')) {
            $query->whereDate('date_cloture_prev', '<=', $request->date_close_end);
        }

        if ($request->filled('probabilite_min')) {
            $query->where('probabilite', '>=', $request->probabilite_min);
        }
        if ($request->filled('probabilite_max')) {
            $query->where('probabilite', '<=', $request->probabilite_max);
        }
        
        // Sécurisation accès commercial : Uniquement ses propres opportunités
        if (auth()->user()->isCommercial()) {
            $query->byCommercial(auth()->id());
        }

        // Clone query for pipeline stats
        $pipelineQuery = clone $query;
        
        // Données pour la vue Liste (paginée)
        $opportunities = $query->orderBy('updated_at', 'desc')->paginate(10);

        // Données pour la vue Pipeline (groupées par stade)
        $pipeline = $pipelineQuery->get()->groupBy('stade');

        // Stats globales du pipeline filtré
        $totalPipelineValue = $pipelineQuery->sum('montant_estime');
        $weightedPipelineValue = $pipelineQuery->get()->sum('weighted_value');

        $users = User::whereIn('role', ['admin', 'commercial'])->get();

        // Stats globaux pour le Header
        $wonCount = isset($pipeline['gagne']) ? $pipeline['gagne']->count() : 0;
        $totalCount = $pipelineQuery->count(); // Use raw count query for accuracy or re-count collection
        // Actually pipelineQuery->get() was used for $pipeline. 
        // $total = collect($pipeline)->flatten()->count(); is redundant if we have $totalCount from query or similar.
        // Let's reuse the logic from blade to be consistent or improvements.
        // In Blade: $total = collect($pipeline)->flatten()->count(); 
        // But $pipeline is grouped.
        // Let's re-calculate cleanly.
        
        $totalStats = collect($pipeline)->flatten()->count();
        $winRate = $totalStats > 0 ? round(($wonCount / $totalStats) * 100, 1) : 0;

        if ($request->ajax() && $request->has('polling')) {
            return response()->json([
                'html' => base64_encode(view('opportunities._content', compact('opportunities', 'pipeline', 'totalPipelineValue', 'weightedPipelineValue', 'users'))->render()),
                'total_opportunities' => $opportunities->total(),
                'total_pipeline_value' => format_currency($totalPipelineValue),
                'weighted_pipeline_value' => format_currency($weightedPipelineValue),
                'win_rate' => $winRate . '%'
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return view('opportunities.index', compact('opportunities', 'pipeline', 'totalPipelineValue', 'weightedPipelineValue', 'users'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $contacts = \App\Models\Contact::orderBy('nom')->get();
        // if (auth()->user()->isCommercial()) {
        //     $contacts = \App\Models\Contact::byUser(auth()->id())->orderBy('nom')->get();
        // }
        
        $users = \App\Models\User::whereIn('role', ['admin', 'commercial'])->orderBy('name')->get();

        return view('opportunities.create', compact('contacts', 'users'));
    }

    /**
     * Stocke une nouvelle opportunité.
     */
    public function store(\App\Http\Requests\StoreOpportunityRequest $request)
    {
        $validated = $request->validated();

        // 1. Create Base Opportunity (without specific commercial if auto requested, but assuming required we use temp or auth)
        // Logic: If Admin selects "Auto" (value 'auto'?) -> AutoAssign. 
        // For now, if Admin provides commercial_id, it is Manual. If no commercial_id (not allowed by validation?), fallback to auth.
        
        // We initialize with the selected commercial or auth user
        $initialCommercialId = auth()->id();
        $shouldAutoAssign = false;

        if (auth()->user()->isAdmin() && $request->filled('commercial_id')) {
            if ($request->commercial_id === 'auto') {
                $shouldAutoAssign = true;
                // keep initialCommercialId as auth() for temporarily creation
            } else {
                 $initialCommercialId = $request->commercial_id;
            }
        }

        $opportunity = Opportunity::create(array_merge(
            collect($validated)->except(['commercial_id'])->toArray(), 
            [
                'commercial_id' => $initialCommercialId, // Will be updated if auto
                'statut' => 'actif',
                'attribution_mode' => $shouldAutoAssign ? 'auto' : 'manual', // Set initial mode
                'assigned_at' => now(),
            ]
        ));

        if ($shouldAutoAssign) {
            $this->attributionService->autoAssign($opportunity);
            // Reload opportunity to check if commercial changed
            $opportunity->refresh();
        } else {
            // Log manually assigned creation
            \App\Models\OpportunityAttributionHistory::create([
                'opportunity_id' => $opportunity->id,
                'assigned_to' => $initialCommercialId,
                'assigned_by' => auth()->id(),
                'mode' => 'manual',
                'reason' => 'Création de l\'opportunité',
            ]);
        }

        // Fire Event for Notifications
        event(new \App\Events\Opportunity\OpportunityCreated($opportunity));

        // Création d'une activité automatique
        \App\Models\Activity::create([
            'contact_id' => $opportunity->contact_id,
            'user_id' => $opportunity->commercial_id, // Use actual owner
            'type' => 'tache',
            'description' => "Création de l'opportunité : " . $opportunity->titre,
            'date_activite' => now(),
            'statut' => 'termine',
            'opportunity_id' => $opportunity->id,
        ]);

        return redirect()->route('opportunities.index')->with('success', 'Opportunité créée avec succès.');
    }

    /**
     * Affiche les détails d'une opportunité.
     */
    public function show(Opportunity $opportunity, Request $request)
    {
        if (auth()->user()->isCommercial()) {
            if ($opportunity->commercial_id != auth()->id()) {
                abort(403, 'Vous n\'êtes pas autorisé à voir cette opportunité.');
            }
        }

        $opportunity->load(['commercial', 'contact', 'attributionHistory.assignedTo', 'attributionHistory.assignedBy']);

        // Filter Activities
        $activitiesQuery = $opportunity->activities()->with('user');

        if ($request->filled('type')) {
            $activitiesQuery->where('type', $request->type);
        }
        if ($request->filled('date_start')) {
            $activitiesQuery->whereDate('date_activite', '>=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $activitiesQuery->whereDate('date_activite', '<=', $request->date_end);
        }

        $opportunity->setRelation('activities', $activitiesQuery->orderBy('date_activite', 'desc')->get());

        return view('opportunities.show', compact('opportunity'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Opportunity $opportunity)
    {
        if (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id()) {
            abort(403);
        }

        $contacts = \App\Models\Contact::orderBy('nom')->get();
        // if (auth()->user()->isCommercial()) {
        //     $contacts = \App\Models\Contact::byUser(auth()->id())->orderBy('nom')->get();
        // }
        
        $users = \App\Models\User::whereIn('role', ['admin', 'commercial'])->orderBy('name')->get();

        return view('opportunities.edit', compact('opportunity', 'contacts', 'users'));
    }

    /**
     * Met à jour une opportunité.
     */
    public function update(\App\Http\Requests\UpdateOpportunityRequest $request, Opportunity $opportunity)
    {
        $validated = $request->validated();
        
        $oldCommercialId = $opportunity->commercial_id;

        // 1. Check Attribution Change
        if ($request->has('commercial_id') && (int)$validated['commercial_id'] !== $opportunity->commercial_id) {
            $newCommercial = User::findOrFail($validated['commercial_id']);
            $this->attributionService->assignManually($opportunity, $newCommercial, auth()->user());
            
            // Notify new commercial
            if ($newCommercial->id !== auth()->id()) {
                $newCommercial->notify(new \App\Notifications\EntityAssigned(
                    'opportunity',
                    $opportunity,
                    auth()->user(),
                    "Vous avez été assigné à l'opportunité : {$opportunity->titre}"
                ));
            }
        }

        // 2. Check Stage Change
        if ($request->has('stade') && $validated['stade'] !== $opportunity->stade) {
            $opportunity->moveToStage($validated['stade'], auth()->id());
        }

        // 3. Update other fields (excluding already handled ones to avoid overwriting or duplicates)
        $opportunity->update(collect($validated)->except(['stade', 'commercial_id'])->toArray());

        // Fire Event for Notifications (unless already fired by moveToStage)
        if (!$request->has('stade') || $validated['stade'] === $opportunity->stade) {
            event(new \App\Events\Opportunity\OpportunityUpdated($opportunity));
        }

        return redirect()->route('opportunities.index')->with('success', 'Opportunité mise à jour.');
    }

    /**
     * Met à jour uniquement le stade d'une opportunité (via AJAX).
     */
    public function updateStage(Request $request, Opportunity $opportunity)
    {
        // 1. Autorisation : Admin ou Commercial propriétaire
        if (auth()->user()->isSupport()) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }

        if (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id()) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }

        $request->validate([
            'stade' => 'required|string|in:prospection,qualification,proposition,negociation,gagne,perdu'
        ]);

        $oldStage = $opportunity->stade;
        $newStage = $request->stade;

        if ($opportunity->moveToStage($newStage, auth()->id())) {
            return response()->json([
                'success' => true,
                'message' => 'Stade mis à jour avec succès.',
                'old_stage' => $oldStage,
                'new_stage' => $newStage,
                'weighted_value' => format_currency($opportunity->weighted_value)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Aucun changement effectué.'], 200);
    }

    /**
     * Supprime une opportunité.
     */
    public function destroy(Opportunity $opportunity, Request $request)
    {
        if (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id()) {
            abort(403);
        }

        $opportunity->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Opportunité supprimée.']);
        }

        return redirect()->route('opportunities.index', ['view' => $request->view])->with('success', 'Opportunité supprimée.');
    }

    /**
     * Marque une opportunité comme gagnée.
     */
    public function markAsWon(Opportunity $opportunity)
    {
        if (auth()->user()->isSupport()) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        if (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id()) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        $opportunity->moveToStage('gagne', auth()->id());

        return redirect()->back()->with('success', 'Opportunité marquée comme gagnée !');
    }

    /**
     * Marque une opportunité comme perdue.
     */
    public function markAsLost(Opportunity $opportunity)
    {
        if (auth()->user()->isSupport()) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        if (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id()) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        $opportunity->moveToStage('perdu', auth()->id());

        return redirect()->back()->with('error', 'Opportunité marquée comme perdue.');
    }

    /**
     * Traite les transitions complexes avec données additionnelles.
     */
    public function processTransition(Request $request, Opportunity $opportunity)
    {
        if (auth()->user()->isSupport() || (auth()->user()->isCommercial() && $opportunity->commercial_id != auth()->id())) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        $validated = $request->validate([
            'stade' => 'required|string|in:prospection,qualification,proposition,negociation,gagne,perdu',
            // Prospection -> Qualification
            'type_premier_contact' => 'nullable|string',
            'date_premier_contact' => 'nullable|date',
            'resume_premier_contact' => 'nullable|string',
            'niveau_interet' => 'nullable|string',
            // Qualification -> Proposition
            'besoin' => 'nullable|string',
            'budget_estime' => 'nullable|numeric',
            'pouvoir_decision' => 'nullable|string',
            'delai_projet_cat' => 'nullable|string',
            'priorite_qualification' => 'nullable|string',
            'score' => 'nullable|integer',
            // Proposition -> Négociation
            'type_proposition' => 'nullable|string',
            'montant_propose' => 'nullable|numeric',
            'description_offre' => 'nullable|string',
            'document_offre' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'send_email' => 'nullable|boolean',
            // Négociation logic
            'feedback_negociation' => 'nullable|string',
            'obstacles_negoc' => 'nullable|string',
            'probabilite_finale' => 'nullable|integer',
            'date_decision_prevue' => 'nullable|date',
            // Perdu
            'motif_perte' => 'nullable|string',
            'commentaire_perte' => 'nullable|string',
            'relancer_plus_tard_date' => 'nullable|date',
            // Gagne / Client
            'nom_client_final' => 'nullable|string',
            'type_client' => 'nullable|string',
            'create_project' => 'nullable|boolean',
            'create_order' => 'nullable|boolean',
            'create_invoice' => 'nullable|boolean',
        ]);

        // Handle File Upload for Document Offre
        if ($request->hasFile('document_offre')) {
            $path = $request->file('document_offre')->store('opportunities/documents', 'public');
            $validated['document_offre'] = $path;
        }

        // Logic check: If it's just a save without stage change (Modal 1 specific requirement)
        $stayInStage = $request->boolean('stay_in_stage');
        $newStage = $stayInStage ? $opportunity->stade : $validated['stade'];

        // Update Fields
        $opportunity->update(collect($validated)->except(['stade', 'document_offre', 'stay_in_stage', 'send_email', 'create_project', 'create_order', 'create_invoice'])->toArray());

        // Process Stage Transition if needed
        if ($opportunity->stade !== $newStage) {
            $opportunity->moveToStage($newStage, auth()->id());
        }

        // Add an activity log for the transition data if significant
        if ($request->filled('resume_premier_contact')) {
             $opportunity->activities()->create([
                'user_id' => auth()->id(),
                'contact_id' => $opportunity->contact_id,
                'type' => 'note',
                'description' => "Compte-rendu du premier contact : " . $validated['resume_premier_contact'],
                'date_activite' => $validated['date_premier_contact'] ?? now(),
            ]);
        }

        // Hypothetical Logic for Projects/Invoices (Placeholder as requested in Modal 5)
        if ($newStage === 'gagne') {
            if ($request->boolean('create_project')) {
                // Logic to create project...
                AuditLog::log('opportunity_auto_project_creation', $opportunity);
            }
        }

        $message = $stayInStage ? 'Données enregistrées.' : 'Transition vers ' . ucfirst($newStage) . ' effectuée.';
        
        return redirect()->back()->with('success', $message);
    }
}
