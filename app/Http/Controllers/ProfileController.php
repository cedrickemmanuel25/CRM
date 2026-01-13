<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de modification du profil.
     */
    public function edit()
    {
        // Restriction: Les administrateurs n'ont pas accès à cette page de profil simplifiée
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Les administrateurs gèrent leur profil via les paramètres globaux.');
        }

        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Met à jour les informations du profil.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            abort(403, 'Action non autorisée pour les administrateurs.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }
}
