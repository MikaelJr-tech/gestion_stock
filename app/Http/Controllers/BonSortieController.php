<?php

namespace App\Http\Controllers;

use App\Models\BonSortie;
use App\Models\LigneBonSortie;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BonSortieController extends Controller
{
    public function index()
    {
        $bons = BonSortie::with('user')->latest()->paginate(15);
        return view('ventes.bons-sortie.index', compact('bons'));
    }

    public function create()
    {
        $produits = Produit::where('stock_actuel', '>', 0)->get();
        return view('ventes.bons-sortie.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motif'                      => 'required|in:périmé,non_vendu,casse,autre',
            'date_sortie'                => 'required|date',
            'notes'                      => 'nullable|string',
            'produits'                   => 'required|array|min:1',
            'produits.*.produit_id'      => 'required|exists:produits,id',
            'produits.*.quantite'        => 'required|integer|min:1',
            'produits.*.valeur_unitaire' => 'required|numeric|min:0',
        ]);

        $numero = 'BS-' . date('Ymd') . '-' . str_pad(BonSortie::count() + 1, 4, '0', STR_PAD_LEFT);

        $bon = BonSortie::create([
            'user_id'     => auth()->id(),
            'numero'      => $numero,
            'motif'       => $request->motif,
            'date_sortie' => $request->date_sortie,
            'notes'       => $request->notes,
        ]);

        foreach ($request->produits as $ligne) {
            LigneBonSortie::create([
                'bon_sortie_id'   => $bon->id,
                'produit_id'      => $ligne['produit_id'],
                'quantite'        => $ligne['quantite'],
                'valeur_unitaire' => $ligne['valeur_unitaire'],
            ]);

            Produit::find($ligne['produit_id'])->decrement('stock_actuel', $ligne['quantite']);
        }

        return redirect()->route('ventes.bons-sortie.index')->with('success', 'Bon de sortie créé avec succès.');
    }

    public function show(BonSortie $bonSortie)
    {
        $bonSortie->load('lignes.produit', 'user');
        return view('ventes.bons-sortie.show', compact('bonSortie'));
    }

    public function edit(BonSortie $bonSortie)
    {
        $produits = Produit::all();
        $bonSortie->load('lignes.produit');
        return view('ventes.bons-sortie.edit', compact('bonSortie', 'produits'));
    }

    public function update(Request $request, BonSortie $bonSortie)
    {
        $request->validate([
            'motif'                      => 'required|in:périmé,non_vendu,casse,autre',
            'date_sortie'                => 'required|date',
            'notes'                      => 'nullable|string',
            'produits'                   => 'required|array|min:1',
            'produits.*.produit_id'      => 'required|exists:produits,id',
            'produits.*.quantite'        => 'required|integer|min:1',
            'produits.*.valeur_unitaire' => 'required|numeric|min:0',
        ]);

        // Annuler l'ancien stock
        foreach ($bonSortie->lignes as $ligne) {
            $ligne->produit->increment('stock_actuel', $ligne->quantite);
        }

        $bonSortie->lignes()->delete();
        $bonSortie->update($request->only('motif', 'date_sortie', 'notes'));

        foreach ($request->produits as $ligne) {
            LigneBonSortie::create([
                'bon_sortie_id'   => $bonSortie->id,
                'produit_id'      => $ligne['produit_id'],
                'quantite'        => $ligne['quantite'],
                'valeur_unitaire' => $ligne['valeur_unitaire'],
            ]);

            Produit::find($ligne['produit_id'])->decrement('stock_actuel', $ligne['quantite']);
        }

        return redirect()->route('ventes.bons-sortie.index')->with('success', 'Bon de sortie modifié avec succès.');
    }

    public function destroy(BonSortie $bonSortie)
    {
        foreach ($bonSortie->lignes as $ligne) {
            $ligne->produit->increment('stock_actuel', $ligne->quantite);
        }

        $bonSortie->delete();
        return redirect()->route('ventes.bons-sortie.index')->with('success', 'Bon de sortie supprimé avec succès.');
    }

    public function imprimer(BonSortie $bonSortie)
    {
        $bonSortie->load('lignes.produit', 'user');
        $pdf = Pdf::loadView('pdf.bon-sortie', compact('bonSortie'));
        return $pdf->stream('BS-' . $bonSortie->numero . '.pdf');
    }
}
