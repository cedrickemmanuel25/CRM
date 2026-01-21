<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        if (request()->ajax()) {
            return view('admin.users._table_rows', compact('users'));
        }

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,commercial,support',
            'password' => 'required|string|min:8', // In real app, maybe auto-generate
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        AuditLog::log('create_user', $user, null, $user->toArray());

        // Send email stub
        
        return redirect()->back()->with('success', 'Utilisateur créé.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,commercial,support',
        ]);

        $oldValues = $user->toArray();
        $user->update($validated);
        
        AuditLog::log('update_user', $user, $oldValues, $user->toArray());

        return redirect()->back()->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete(); // Permanent deletion from the database
        
        AuditLog::log('delete_user', $user);

        return redirect()->back()->with('success', 'Utilisateur supprimé.');
    }

    public function resetPassword(User $user)
    {
        $newPass = 'password'; // Default reset
        $user->update(['password' => Hash::make($newPass)]);
        
        AuditLog::log('reset_password', $user);

        return redirect()->back()->with('success', "Mot de passe réinitialisé à '$newPass'.");
    }
}
