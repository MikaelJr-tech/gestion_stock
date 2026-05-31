<?php

namespace App\Http\Controllers;

use App\Models\BonEntree;
use App\Models\LigneBonEntree;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BonEntreeController extends Controller
{
    public function index()
    {
        $bons = BonEntree::with('user')->latest()->paginate(15);
        return view('appro.bons-entree.index', compact('bons'));
    }

    public function create()
    {
        $produits = Produit::all();
        return view('appro.bons-entree.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'                       => 'required|in:don,retour,ajustement,autre',
            'date_entree'                => 'required|date',
            'source'                     => 'nullable|string|max:255',
            'notes'                      => 'nullable|string',
            'produits'                   => 'required|array|min:1',
            'produits.*.produit_id'      => 'required|exists:produits,id',
            'produits.*.quantite'        => 'required|integer|min:1',
            'produits.*.valeur_unitaire' => 'required|numeric|min:0',
        ]);

        $numero = 'BE-' . date('Ymd') . '-' . str_pad(BonEntree::count() + 1, 4, '0', STR_PAD_LEFT);

        $bon = BonEntree::create([
            'user_id'     => auth()->id(),
            'numero'      => $numero,
            'type'        => $request->type,
            'date_entree' => $request->date_entree,
            'source'      => $request->source,
            'notes'       => $request->notes,
        ]);

        foreach ($request->produits as $ligne) {
            LigneBonEntree::create([
                'bon_entree_id'   => $bon->id,
                'produit_id'      => $ligne['produit_id'],
                'quantite'        => $ligne['quantite'],
                'valeur_unitaire' => $ligne['valeur_unitaire'],
            ]);
            Produit::find($ligne['produit_id'])->increment('stock_actuel', $ligne['quantite']);
        }

        return redirect()->route('appro.bons-entree.index')
            ->with('success', 'Bon d\'entrée créé avec succès.');
    }

    public function show(BonEntree $bonEntree)
    {
        $bonEntree->load('lignes.produit', 'user');
        return view('appro.bons-entree.show', compact('bonEntree'));
    }

    public function edit(BonEntree $bonEntree)
    {
        $produits = Produit::all();
        $bonEntree->load('lignes.produit');
        return view('appro.bons-entree.edit', compact('bonEntree', 'produits'));
    }

    public function update(Request $request, BonEntree $bonEntree)
    {
        $request->validate([
            'type'                       => 'required|in:don,retour,ajustement,autre',
            'date_entree'                => 'required|date',
            'source'                     => 'nullable|string|max:255',
            'notes'                      => 'nullable|string',
            'produits'                   => 'required|array|min:1',
            'produits.*.produit_id'      => 'required|exists:produits,id',
            'produits.*.quantite'        => 'required|integer|min:1',
            'produits.*.valeur_unitaire' => 'required|numeric|min:0',
        ]);

        foreach ($bonEntree->lignes as $ligne) {
            $ligne->produit->decrement('stock_actuel', $ligne->quantite);
        }

        $bonEntree->lignes()->delete();
        $bonEntree->update($request->only('type', 'date_entree', 'source', 'notes'));

        foreach ($request->produits as $ligne) {
            LigneBonEntree::create([
                'bon_entree_id'   => $bonEntree->id,
                'produit_id'      => $ligne['produit_id'],
                'quantite'        => $ligne['quantite'],
                'valeur_unitaire' => $ligne['valeur_unitaire'],
            ]);
            Produit::find($ligne['produit_id'])->increment('stock_actuel', $ligne['quantite']);
        }

        return redirect()->route('appro.bons-entree.index')
            ->with('success', 'Bon d\'entrée modifié avec succès.');
    }

    public function destroy(BonEntree $bonEntree)
    {
        $bonEntree->load('lignes.produit');

        // Annuler le stock avant suppression
        foreach ($bonEntree->lignes as $ligne) {
            $ligne->produit->decrement('stock_actuel', $ligne->quantite);
        }

        // Archiver
        ArchiveController::archiver('bon_entree', $bonEntree);

        $bonEntree->delete();
        return redirect()->route('appro.bons-entree.index')
            ->with('success', 'Bon d\'entrée supprimé et archivé en XML.');
    }

    public function imprimer(BonEntree $bonEntree)
    {
        $bonEntree->load('lignes.produit', 'user');
        $pdf = Pdf::loadView('pdf.bon-entree', compact('bonEntree'));
        return $pdf->stream('BE-' . $bonEntree->numero . '.pdf');
    }
}
