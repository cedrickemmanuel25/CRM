<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\AccessRequest;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Affiche le profil de l'administrateur avec statistiques système.
     */
    public function edit()
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est bien admin
        if (!$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Statistiques système
        $stats = [
            'total_users' => User::count(),
            'pending_requests' => AccessRequest::pending()->count(),
            'total_contacts' => Contact::count(),
            'total_opportunities' => Opportunity::count(),
            'recent_activities' => Activity::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return view('admin.profile.edit', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    /**
     * Met à jour le profil de l'administrateur.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est bien admin
        if (!$user->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telephone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->telephone = $validated['telephone'];

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar si nécessaire
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil administrateur mis à jour avec succès.');
    }
}
