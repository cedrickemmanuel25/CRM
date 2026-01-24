<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Liste des tâches (Vue Tableau/Liste)
     */
    /**
     * Liste des tâches (Vue Tableau/Kanban)
     */
    public function index(Request $request)
    {
        return redirect()->route('calendar');
    }

    /**
     * Vue Calendrier Unifiée (Calendrier + Tâches)
     */
    public function calendar(Request $request)
    {
        $currentUser = auth()->user();
        
        // 1. Get Categories/Users for filters
        $users = User::all();
        $contacts = \App\Models\Contact::orderBy('nom')->get();
        $opportunities = \App\Models\Opportunity::active()->orderBy('titre')->get();

        // 2. Fetch Tasks for the Board/List
        $query = Task::with(['assignee', 'related']);
        
        // Apply filters
        if ($request->filled('assigned_to')) {
            $query->byUser($request->assigned_to);
        }
        if (!auth()->user()->isAdmin() && !$request->filled('assigned_to')) {
             $query->byUser(auth()->id());
        }
        
        if ($request->filled('date')) {
            $query->whereDate('due_date', $request->date);
        }

        $allTasks = $query->orderBy('due_date')->get();
        $tasks = [
            'todo' => $allTasks->where('statut', 'todo'),
            'in_progress' => $allTasks->where('statut', 'in_progress'),
            'done' => $allTasks->where('statut', 'done'),
        ];

        // 3. Events for the Calendar (Full view)
        $tasksQuery = Task::whereNotNull('due_date');
        if (!$currentUser->isAdmin()) {
            $tasksQuery->where(function($q) use ($currentUser) {
                $q->where('created_by', $currentUser->id)
                  ->orWhere('assigned_to', $currentUser->id);
            });
        }
        
        $calendarTasks = $tasksQuery->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => 'T: ' . $task->titre,
                'start' => $task->due_date->format('Y-m-d H:i:s'),
                'className' => 'bg-indigo-500 text-white border-indigo-600',
                'type' => 'task',
                'extendedProps' => ['priority' => $task->priority, 'statut' => $task->statut]
            ];
        });

        $activitiesQuery = Activity::query();
        if (!$currentUser->isAdmin()) {
            $activitiesQuery->where('user_id', $currentUser->id);
        }

        $calendarActivities = $activitiesQuery->get()->map(function ($act) {
            $colorMap = ['appel' => 'bg-blue-500', 'email' => 'bg-purple-500', 'reunion' => 'bg-amber-500', 'note' => 'bg-gray-500'];
            return [
                'id' => $act->id,
                'title' => ucfirst($act->type) . ': ' . $act->description,
                'start' => $act->date_activite->format('Y-m-d H:i:s'),
                'className' => ($colorMap[$act->type] ?? 'bg-green-500') . ' text-white',
                'type' => $act->type
            ];
        });

        $events = $calendarTasks->concat($calendarActivities);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('tasks._board', compact('tasks', 'users', 'contacts', 'opportunities'))->render(),
                'events' => $events
            ]);
        }

        return view('calendar.index', compact('events', 'tasks', 'users', 'contacts', 'opportunities'));
    }

    public function show(Task $task)
    {
        // Autorisation : Admin voit tout, les autres voient seulement ce qui leur est assigné ou créé
        if (!auth()->user()->isAdmin() && $task->assigned_to !== auth()->id() && $task->created_by !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette tâche.');
        }

        $task->load(['assignee', 'creator', 'related']);
        return view('tasks.show', compact('task'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'related_id' => 'nullable|integer',
            'related_type' => 'nullable|string',
        ]);

        $task = Task::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'statut' => 'todo',
            'created_by' => auth()->id(),
            'related_id' => $validated['related_id'] ?? null,
            'related_type' => $validated['related_type'] ?? null,
        ]);
        
        // Fire Event for Notifications
        event(new \App\Events\Task\TaskCreated($task));

        $redirect = redirect()->back();
        
        // Si c'est lié à un contact, on veut retourner sur l'onglet tâches
        if ($request->related_type === 'App\Models\Contact') {
            $redirect->withFragment('tasks');
        }

        return $redirect->with('success', 'Tâche créée.');
    }

    public function update(Request $request, Task $task)
    {
        // Autorisation : Admin ou Assigné/Créateur
        if (!auth()->user()->isAdmin() && $task->assigned_to !== auth()->id() && $task->created_by !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette tâche.');
        }

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'statut' => 'sometimes|in:todo,in_progress,done',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'sometimes|date',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Task $task)
    {
        // Autorisation : Admin ou Créateur (Généralement seul le créateur peut supprimer)
        if (!auth()->user()->isAdmin() && $task->created_by !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette tâche.');
        }

        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée.');
    }
}
