<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GroupeController extends Controller
{
    public function index()
    {
        $groupes = Role::with('permissions')->get();
        return view('groupes.index', compact('groupes'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);
        return view('groupes.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('groupes.index')->with('success', 'Groupe créé avec succès.');
    }

    public function show(Role $groupe)
    {
        $groupe->load('permissions');
        return view('groupes.show', compact('groupe'));
    }

    public function edit(Role $groupe)
    {
        $permissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);
        return view('groupes.edit', compact('groupe', 'permissions'));
    }

    public function update(Request $request, Role $groupe)
    {
        $request->validate([
            'name'        => 'required|string|unique:roles,name,' . $groupe->id,
            'permissions' => 'nullable|array',
        ]);

        $groupe->update(['name' => $request->name]);
        $groupe->syncPermissions($request->permissions ?? []);

        return redirect()->route('groupes.index')->with('success', 'Groupe modifié avec succès.');
    }

    public function destroy(Role $groupe)
    {
        $groupe->delete();
        return redirect()->route('groupes.index')->with('success', 'Groupe supprimé avec succès.');
    }
}
