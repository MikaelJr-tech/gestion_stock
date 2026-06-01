<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('utilisateurs.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('utilisateurs.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $utilisateur)
    {
        $utilisateur->load('roles');
        return view('utilisateurs.show', compact('utilisateur'));
    }

    public function edit(User $utilisateur)
    {
        $roles = Role::all();
        return view('utilisateurs.edit', compact('utilisateur', 'roles'));
    }

    public function update(Request $request, User $utilisateur)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $utilisateur->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $utilisateur->update($request->only('name', 'email'));

        if ($request->password) {
            $utilisateur->update(['password' => bcrypt($request->password)]);
        }

        $utilisateur->syncRoles([$request->role]);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $utilisateur)
    {
        // Empêcher l'admin de se supprimer lui-même
        if (auth()->id() === $utilisateur->id) {
            return redirect()->route('utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Archiver avant suppression
        ArchiveController::archiver('utilisateur', $utilisateur);

        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé et archivé en XML.');
    }
}