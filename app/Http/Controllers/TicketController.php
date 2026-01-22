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
        if (auth()->user()->isCommercial()) {
             // Commercials see tickets they created OR tickets linked to THEIR contacts
             $query->where(function($q) {
                 $q->where('user_id', auth()->id())
                   ->orWhereHas('contact', function($qContact) {
                       $qContact->where('user_id_owner', auth()->id());
                   });
             });
        } elseif (!auth()->user()->isAdmin() && !auth()->user()->isSupport()) {
             // Other roles (visitor/etc) only see own created if any
             $query->where('user_id', auth()->id());
        }
        // Admin and Support see everything

        $tickets = $query->latest()->paginate(15);
        $users = User::whereIn('role', ['admin', 'support'])->get();
        $contacts = Contact::orderBy('nom')->get();

        return view('tickets.index', compact('tickets', 'users', 'contacts'));
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

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket créé avec succès.',
                'redirect' => route('tickets.show', $ticket)
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Autorisation : Admin/Support voient tout. Commercial voit les siens ou ceux de ses contacts.
        if (auth()->user()->isCommercial()) {
            $isOwner = $ticket->user_id === auth()->id();
            $isContactOwner = $ticket->contact && $ticket->contact->user_id_owner === auth()->id();
            
            if (!$isOwner && !$isContactOwner) {
                abort(403, 'Vous n\'êtes pas autorisé à voir ce ticket.');
            }
        }

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
        if (!auth()->user()->isAdmin() && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

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
