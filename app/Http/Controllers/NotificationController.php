<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\NotificationPreference;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function fetch()
    {
        $user = Auth::user();
        $count = $user->unreadNotifications->count();
        $notifications = $user->unreadNotifications->take(5)->map(function ($n) {
            return [
                'id' => $n->id,
                'data' => $n->data,
                'created_at' => $n->created_at,
                'read_at' => $n->read_at
            ];
        });

        return response()->json([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request, $id = null)
    {
        if ($id) {
            Auth::user()->notifications()->where('id', $id)->first()?->markAsRead();
        } else {
            Auth::user()->unreadNotifications->markAsRead();
        }
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        Auth::user()->notifications()->where('id', $id)->first()?->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification supprimée.');
    }

    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        return redirect()->back()->with('success', 'Toutes les notifications ont été supprimées.');
    }

    public function settings()
    {
        $preferences = NotificationPreference::where('user_id', Auth::id())->get()->keyBy('event_type');
        
        $eventTypes = [
            'contact_created' => 'Contact créé',
            'contact_updated' => 'Contact modifié',
            'contact_deleted' => 'Contact supprimé',
            'opportunity_created' => 'Opportunité créée',
            'opportunity_updated' => 'Opportunité modifiée',
            'opportunity_won' => 'Opportunité gagnée',
            'opportunity_lost' => 'Opportunité perdue',
            'task_created' => 'Tâche créée',
            'task_completed' => 'Tâche terminée',
            'task_overdue' => 'Tâche en retard',
        ];

        return view('profile.notifications', compact('preferences', 'eventTypes'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $types = [
            'contact_created', 'contact_updated', 'contact_deleted',
            'opportunity_created', 'opportunity_updated', 'opportunity_won', 'opportunity_lost',
            'task_created', 'task_completed', 'task_overdue'
        ];

        foreach ($types as $type) {
            NotificationPreference::updateOrCreate(
                ['user_id' => $user->id, 'event_type' => $type],
                [
                    'email_enabled' => $request->has("preferences.$type.email"),
                    'push_enabled' => $request->has("preferences.$type.push"),
                ]
            );
        }

        return redirect()->back()->with('success', 'Préférences mises à jour.');
    }
}
