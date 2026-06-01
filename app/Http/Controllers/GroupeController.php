<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use SimpleXMLElement;
use Illuminate\Support\Facades\Storage;

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

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe créé avec succès.');
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

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe modifié avec succès.');
    }

    public function destroy(Role $groupe)
    {
        // Archiver le groupe avec ses permissions
        $this->archiverGroupe($groupe);

        $groupe->delete();

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe supprimé et archivé en XML.');
    }

    // ── Archivage spécial pour les Roles Spatie ──────────────────
    private function archiverGroupe(Role $groupe): void
    {
        $groupe->load('permissions', 'users');

        $xml  = new SimpleXMLElement('<archive/>');
        $xml->addChild('type', 'groupe');
        $xml->addChild('date_suppression', now()->toISOString());
        $xml->addChild('supprime_par', auth()->user()->name ?? 'Système');

        // Données principales du groupe
        $enregs = $xml->addChild('enregistrements');
        $enreg  = $enregs->addChild('enregistrement');
        $enreg->addChild('id',         (string) $groupe->id);
        $enreg->addChild('name',       htmlspecialchars($groupe->name));
        $enreg->addChild('guard_name', htmlspecialchars($groupe->guard_name));

        // Permissions associées
        $permsNode = $xml->addChild('permissions');
        foreach ($groupe->permissions as $perm) {
            $permNode = $permsNode->addChild('permission');
            $permNode->addChild('name', htmlspecialchars($perm->name));
        }

        // Utilisateurs qui avaient ce rôle
        $usersNode = $xml->addChild('utilisateurs');
        foreach ($groupe->users as $user) {
            $userNode = $usersNode->addChild('utilisateur');
            $userNode->addChild('id',    (string) $user->id);
            $userNode->addChild('name',  htmlspecialchars($user->name));
            $userNode->addChild('email', htmlspecialchars($user->email));
        }

        $nom = 'groupe_' . $groupe->id . '_' . now()->format('Ymd_His') . '.xml';
        Storage::put('archives/' . $nom, $xml->asXML());
    }
}