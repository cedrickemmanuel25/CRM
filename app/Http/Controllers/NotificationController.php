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
            'task_assigned' => 'Nouvelle tâche assignée',
            'task_reminder' => 'Rappel de tâche',
        ];

        return view('profile.notifications', compact('preferences', 'eventTypes'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $types = ['task_assigned', 'task_reminder']; // Allowed types

        foreach ($types as $type) {
            NotificationPreference::updateOrCreate(
                ['user_id' => $user->id, 'event_type' => $type],
                [
                    'mail' => $request->has("preferences.$type.mail"),
                    'database' => $request->has("preferences.$type.database"),
                ]
            );
        }

        return redirect()->back()->with('success', 'Préférences mises à jour.');
    }
}
