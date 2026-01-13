<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['contact', 'assignee', 'creator']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Logic by role
        if (!auth()->user()->isAdmin() && !auth()->user()->isSupport()) {
             // Commercials/Others only see tickets they created or assigned to their contacts?
             // For now, let's keep it Support-centric as per prompt.
             // If not support/admin, only see own created tickets.
             $query->where('user_id', auth()->id());
        }

        $tickets = $query->latest()->paginate(15);
        $users = User::whereIn('role', ['admin', 'support'])->get();

        return view('tickets.index', compact('tickets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('nom')->get();
        $users = User::whereIn('role', ['admin', 'support'])->get();
        return view('tickets.create', compact('contacts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:technical,commercial,billing,feature_request,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'contact_id' => 'required|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:5120',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('tickets/attachments', 'public');
            $validated['attachment'] = $path;
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'new';

        $ticket = Ticket::create($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['contact', 'assignee', 'creator', 'activities.user']);
        $users = User::whereIn('role', ['admin', 'support'])->get();
        
        return view('tickets.show', compact('ticket', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $contacts = Contact::orderBy('nom')->get();
        $users = User::whereIn('role', ['admin', 'support'])->get();
        return view('tickets.edit', compact('ticket', 'contacts', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'subject' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:new,in_progress,resolved,closed',
            'category' => 'sometimes|required|string|in:technical,commercial,billing,feature_request,other',
            'priority' => 'sometimes|required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        }

        return redirect()->back()->with('success', 'Ticket mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé.');
    }

    /**
     * Add a response to the ticket.
     */
    public function addResponse(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->activities()->create([
            'user_id' => auth()->id(),
            'type' => 'interaction',
            'description' => 'Réponse au ticket',
            'contenu' => $request->message,
            'date_activite' => now(),
            'statut' => 'termine',
        ]);

        return redirect()->back()->with('success', 'Réponse ajoutée.');
    }
}
