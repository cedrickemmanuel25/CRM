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
        $query = Task::with(['assignee', 'related']);

        // Filtres
        if ($request->filled('assigned_to')) {
            $query->byUser($request->assigned_to);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        // Par défaut, voir ses propres tâches sauf si admin
        if (!auth()->user()->isAdmin() && !$request->filled('assigned_to')) {
             $query->byUser(auth()->id());
        } elseif ($request->filled('assigned_to')) {
            $query->byUser($request->assigned_to);
        }

        // Filter by Status if list view requested specific columns
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Date Range Filtering
        if ($request->filled('date_start')) {
            $query->whereDate('due_date', '>=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $query->whereDate('due_date', '<=', $request->date_end);
        }
        
        // Quick Filters
        // Filtre "En retard"
        if ($request->filled('overdue') && $request->overdue == 1) {
            $query->overdue();
        }
        
        // Filtre "À venir"
        if ($request->filled('upcoming') && $request->upcoming == 1) {
            $query->where('due_date', '>=', now())
                  ->where('statut', '!=', 'done');
        }
        
        // Filtre "Mes tâches" (raccourci rapide)
        if ($request->filled('my_tasks') && $request->my_tasks == 1) {
            $query->byUser(auth()->id());
        }
        
        // Fetch all matching tasks for Kanban grouping
        $allTasks = $query->orderBy('due_date')->get();
        
        $tasks = [
            'todo' => $allTasks->where('statut', 'todo'),
            'in_progress' => $allTasks->where('statut', 'in_progress'),
            'done' => $allTasks->where('statut', 'done'),
        ];
        
        $users = User::all();
        $contacts = \App\Models\Contact::orderBy('nom')->get();
        $opportunities = \App\Models\Opportunity::active()->orderBy('titre')->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('tasks._board', compact('tasks', 'users', 'contacts', 'opportunities'))->render(),
                'total_tasks' => $tasks['todo']->count() + $tasks['in_progress']->count() + $tasks['done']->count(),
                'tasks_due_today' => \App\Models\Task::whereDate('due_date', today())->count(),
                'tasks_high_priority' => \App\Models\Task::where('priority', 'high')->where('statut', '!=', 'done')->count()
            ]);
        }

        return view('tasks.index', compact('tasks', 'users', 'contacts', 'opportunities'));
    }

    /**
     * Vue Calendrier (Tâches + Activités)
     */
    public function calendar(Request $request)
    {
        $currentUser = auth()->user();
        
        // Tasks Query
        $tasksQuery = Task::whereNotNull('due_date');
        
        if (!$currentUser->isAdmin()) {
            $tasksQuery->where(function($q) use ($currentUser) {
                $q->where('created_by', $currentUser->id)
                  ->orWhere('assigned_to', $currentUser->id)
                  ->orWhere(function($subQ) use ($currentUser) {
                      $subQ->where('related_type', \App\Models\Contact::class)
                           ->whereIn('related_id', $currentUser->contacts()->select('id'));
                  });
            });
        }
        
        $tasks = $tasksQuery->get()->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => 'T: ' . $task->titre,
                    'start' => $task->due_date->format('Y-m-d H:i:s'),
                    'className' => 'bg-indigo-500 text-white border-indigo-600',
                    'type' => 'task',
                    'url' => route('tasks.index'), // Or open modal
                    'extendedProps' => [
                        'priority' => $task->priority,
                        'statut' => $task->statut
                    ]
                ];
            });

        // Activities Query
        $activitiesQuery = Activity::query();

        if (!$currentUser->isAdmin()) {
            $activitiesQuery->where(function($q) use ($currentUser) {
               $q->where('user_id', $currentUser->id) // Created by
                 ->orWhere(function($subQ) use ($currentUser) {
                     $subQ->where('parent_type', \App\Models\Contact::class)
                          ->whereIn('parent_id', $currentUser->contacts()->select('id'));
                 });
            });
        }

        $activities = $activitiesQuery->get()->map(function ($act) {
                $colorMap = [
                    'appel' => 'bg-blue-500 text-white border-blue-600',
                    'email' => 'bg-purple-500 text-white border-purple-600',
                    'reunion' => 'bg-amber-500 text-white border-amber-600',
                    'note' => 'bg-gray-500 text-white border-gray-600',
                ];

                return [
                    'id' => $act->id,
                    'title' => ucfirst($act->type) . ': ' . $act->description,
                    'start' => $act->date_activite->format('Y-m-d H:i:s'),
                    'className' => $colorMap[$act->type] ?? 'bg-green-500 text-white border-green-600',
                    'type' => 'activity',
                    'activityType' => $act->type,
                    'extendedProps' => [
                        'parent' => $act->parent_type ? class_basename($act->parent_type) : null
                    ]
                ];
            });

        $events = $tasks->concat($activities);

        if ($request->wantsJson()) {
            return response()->json($events);
        }

        $users = User::all();

        return view('calendar.index', compact('events', 'users'));
    }

    public function show(Task $task)
    {
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
        
        // Notification
        if ($task->assigned_to && $task->assigned_to !== auth()->id()) {
            $assignee = User::find($task->assigned_to);
            if ($assignee) {
                $assignee->notify(new \App\Notifications\EntityAssigned(
                    'task',
                    $task,
                    auth()->user(),
                    "Nouvelle tâche assignée : {$task->titre}"
                ));
            }
        }

        $redirect = redirect()->back();
        
        // Si c'est lié à un contact, on veut retourner sur l'onglet tâches
        if ($request->related_type === 'App\Models\Contact') {
            $redirect->withFragment('tasks');
        }

        return $redirect->with('success', 'Tâche créée.');
    }

    public function update(Request $request, Task $task)
    {
        // Policy check needed in real app

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
        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée.');
    }
}
