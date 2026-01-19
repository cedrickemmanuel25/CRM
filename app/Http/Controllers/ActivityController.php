<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Journal d'activité global
     */
    public function index()
    {
        $query = Activity::with(['user', 'parent']);

        // Sécurisation accès commercial
        if (auth()->user()->isCommercial()) {
            $query->where('user_id', auth()->id());
        }

        $activities = $query->latest('date_activite')
            ->paginate(20);

        return view('activities.index', compact('activities'));
    }

    /**
     * Stocke une activité liée à un parent (Contact ou Opportunité)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:appel,email,reunion,note,ticket,tache',
            'description' => 'required|string',
            'date_activite' => 'required|date',
            'duree' => 'nullable|integer',
            'parent_type' => 'required|string',
            'parent_id' => 'required|integer',
            'statut' => 'nullable|string',
            'priorite' => 'nullable|string',
            'contenu' => 'nullable|string',
            'piece_jointe' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $path = null;
        if ($request->hasFile('piece_jointe')) {
            $path = $request->file('piece_jointe')->store('activites', 'public');
        }

        Activity::create([
            'user_id' => auth()->id(),
            'parent_type' => $validated['parent_type'], // Ensure valid mapping in frontend (App\Models\Contact etc)
            'parent_id' => $validated['parent_id'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'date_activite' => $validated['date_activite'],
            'duree' => $validated['duree'] ?? null,
            'statut' => $validated['statut'] ?? 'termine',
            'priorite' => $validated['priorite'] ?? 'normale',
            'contenu' => $validated['contenu'] ?? null,
            'piece_jointe' => $path,
        ]);

        return redirect()->back()->with('success', 'Activité enregistrée avec succès.');
    }
}
