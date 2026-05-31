<?php

namespace App\Http\Controllers;

use App\Models\FamilleProduit;
use Illuminate\Http\Request;

class FamilleProduitController extends Controller
{
    public function index()
    {
        $familles = FamilleProduit::withCount('produits')->latest()->paginate(15);
        return view('familles.index', compact('familles'));
    }

    public function create()
    {
        return view('familles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        FamilleProduit::create($request->all());
        return redirect()->route('familles.index')
            ->with('success', 'Famille créée avec succès.');
    }

    public function show(FamilleProduit $famille)
    {
        $produits = $famille->produits()->paginate(15);
        return view('familles.show', compact('famille', 'produits'));
    }

    public function edit(FamilleProduit $famille)
    {
        return view('familles.edit', compact('famille'));
    }

    public function update(Request $request, FamilleProduit $famille)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $famille->update($request->all());
        return redirect()->route('familles.index')
            ->with('success', 'Famille modifiée avec succès.');
    }

    public function destroy(FamilleProduit $famille)
    {
        ArchiveController::archiver('famille_produit', $famille);
        $famille->delete();
        return redirect()->route('familles.index')
            ->with('success', 'Famille supprimée et archivée en XML.');
    }
}
