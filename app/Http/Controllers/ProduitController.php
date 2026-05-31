<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\FamilleProduit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('famille')->latest()->paginate(15);
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        $familles = FamilleProduit::all();
        $parents  = Produit::where('type', 'père')->get();
        return view('produits.create', compact('familles', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'famille_id'       => 'required|exists:familles_produits,id',
            'code'             => 'required|string|unique:produits,code',
            'nom'              => 'required|string|max:255',
            'unite'            => 'required|string|max:50',
            'prix_achat'       => 'required|numeric|min:0',
            'prix_vente'       => 'required|numeric|min:0',
            'stock_minimum'    => 'required|integer|min:0',
            'type'             => 'required|in:simple,père,fils',
            'facteur_fraction' => 'nullable|numeric|min:1',
            'date_expiration'  => 'nullable|date',
        ]);

        Produit::create($request->all());
        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function show(Produit $produit)
    {
        $produit->load('famille', 'produitsFils');
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $familles = FamilleProduit::all();
        $parents  = Produit::where('type', 'père')->where('id', '!=', $produit->id)->get();
        return view('produits.edit', compact('produit', 'familles', 'parents'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'famille_id'       => 'required|exists:familles_produits,id',
            'code'             => 'required|string|unique:produits,code,' . $produit->id,
            'nom'              => 'required|string|max:255',
            'unite'            => 'required|string|max:50',
            'prix_achat'       => 'required|numeric|min:0',
            'prix_vente'       => 'required|numeric|min:0',
            'stock_minimum'    => 'required|integer|min:0',
            'type'             => 'required|in:simple,père,fils',
            'facteur_fraction' => 'nullable|numeric|min:1',
            'date_expiration'  => 'nullable|date',
        ]);

        $produit->update($request->all());
        return redirect()->route('produits.index')
            ->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit)
    {
        ArchiveController::archiver('produit', $produit);
        $produit->delete();
        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé et archivé en XML.');
    }

    public function fractionner(Produit $produit)
    {
        $fils = $produit->produitsFils()->get();
        return view('produits.fractionner', compact('produit', 'fils'));
    }
}
