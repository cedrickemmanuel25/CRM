<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAccessRequestNotification;
use App\Notifications\AccessRequestApprovedNotification;
use App\Notifications\AccessRequestApprovedAdminNotification;

class AccessRequestController extends Controller
{
    public function showForm()
    {
        return view('auth.request-access');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:access_requests,email',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,commercial,support',
        ]);

        $accessRequest = AccessRequest::create($validated);

        // Notifier tous les administrateurs
        $admins = User::admins()->get();
        Notification::send($admins, new NewAccessRequestNotification($accessRequest));

        return redirect()->route('login')->with('success', 'Votre demande d\'accès a été envoyée à l\'administrateur.');
    }

    public function index()
    {
        $requests = AccessRequest::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        
        if (request()->ajax()) {
            return view('admin.access_requests._table_rows', compact('requests'));
        }

        return view('admin.access_requests.index', compact('requests'));
    }

    public function stats()
    {
        // Check admin permissions (though route middleware should handle this)
        if (!auth()->user()->isAdmin()) {
            return response()->json(['count' => 0], 403);
        }
        
        return response()->json([
            'count' => AccessRequest::where('status', 'pending')->count()
        ]);
    }

    public function approve($id)
    {
        $accessRequest = AccessRequest::findOrFail($id);
        $tempPassword = 'Bienvenue' . rand(100, 999) . '!';

        $user = User::create([
            'name' => $accessRequest->prenom . ' ' . $accessRequest->nom,
            'email' => $accessRequest->email,
            'role' => $accessRequest->role,
            'password' => Hash::make($tempPassword),
            'telephone' => $accessRequest->telephone,
        ]);

        $accessRequest->update(['status' => 'approved']);

        // Notifier l'utilisateur par email
        $user->notify(new AccessRequestApprovedNotification([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $tempPassword
        ]));

        // Notifier l'administrateur qui a fait l'action (en base de données pour persistance)
        auth()->user()->notify(new AccessRequestApprovedAdminNotification([
            'user_name' => $user->name,
            'password' => $tempPassword,
            'user_id' => $user->id
        ]));

        AuditLog::log('approve_access_request', $user, null, ['request_id' => $id]);

        return redirect()->back()->with('success', "Demande approuvée. L'utilisateur a été créé et notifié par email. (Mot de passe : $tempPassword)");
    }

    public function reject($id)
    {
        $accessRequest = AccessRequest::findOrFail($id);
        $accessRequest->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Demande rejetée.');
    }
}
