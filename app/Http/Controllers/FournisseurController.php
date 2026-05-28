<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::latest()->paginate(15);
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'                  => 'required|string|max:255',
            'telephone'            => 'nullable|string|max:20',
            'email'                => 'nullable|email|max:255',
            'adresse'              => 'nullable|string',
            'numero_contribuable'  => 'nullable|string|max:100',
        ]);

        Fournisseur::create($request->all());
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur créé avec succès.');
    }

    public function show(Fournisseur $fournisseur)
    {
        $fournisseur->load('bonsCommande', 'factures');
        return view('fournisseurs.show', compact('fournisseur'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom'                  => 'required|string|max:255',
            'telephone'            => 'nullable|string|max:20',
            'email'                => 'nullable|email|max:255',
            'adresse'              => 'nullable|string',
            'numero_contribuable'  => 'nullable|string|max:100',
        ]);

        $fournisseur->update($request->all());
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur modifié avec succès.');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé avec succès.');
    }
}
