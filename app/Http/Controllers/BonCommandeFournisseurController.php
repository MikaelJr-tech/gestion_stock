<?php

namespace App\Http\Controllers;

use App\Models\BonCommandeFournisseur;
use App\Models\LigneCommandeFournisseur;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BonCommandeFournisseurController extends Controller
{
    public function index()
    {
        $commandes = BonCommandeFournisseur::with('fournisseur')->latest()->paginate(15);
        return view('appro.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $produits     = Produit::all();
        return view('appro.commandes.create', compact('fournisseurs', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id'       => 'required|exists:fournisseurs,id',
            'date_commande'        => 'required|date',
            'date_livraison_prevue'=> 'nullable|date',
            'notes'                => 'nullable|string',
            'produits'             => 'required|array|min:1',
            'produits.*.produit_id'=> 'required|exists:produits,id',
            'produits.*.quantite'  => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        $numero   = 'BCF-' . date('Ymd') . '-' . str_pad(BonCommandeFournisseur::count() + 1, 4, '0', STR_PAD_LEFT);
        $montant  = collect($request->produits)->sum(fn($l) => $l['quantite'] * $l['prix_unitaire']);

        $commande = BonCommandeFournisseur::create([
            'fournisseur_id'        => $request->fournisseur_id,
            'user_id'               => auth()->id(),
            'numero'                => $numero,
            'date_commande'         => $request->date_commande,
            'date_livraison_prevue' => $request->date_livraison_prevue,
            'montant_total'         => $montant,
            'notes'                 => $request->notes,
        ]);

        foreach ($request->produits as $ligne) {
            LigneCommandeFournisseur::create([
                'bon_commande_id' => $commande->id,
                'produit_id'      => $ligne['produit_id'],
                'quantite_commandee' => $ligne['quantite'],
                'prix_unitaire'   => $ligne['prix_unitaire'],
                'montant'         => $ligne['quantite'] * $ligne['prix_unitaire'],
            ]);
        }

        return redirect()->route('appro.commandes.index')->with('success', 'Bon de commande créé avec succès.');
    }

    public function show(BonCommandeFournisseur $commande)
    {
        $commande->load('fournisseur', 'lignes.produit', 'user');
        return view('appro.commandes.show', compact('commande'));
    }

    public function edit(BonCommandeFournisseur $commande)
    {
        $fournisseurs = Fournisseur::all();
        $produits     = Produit::all();
        $commande->load('lignes.produit');
        return view('appro.commandes.edit', compact('commande', 'fournisseurs', 'produits'));
    }

    public function update(Request $request, BonCommandeFournisseur $commande)
    {
        $request->validate([
            'fournisseur_id'        => 'required|exists:fournisseurs,id',
            'date_commande'         => 'required|date',
            'date_livraison_prevue' => 'nullable|date',
            'notes'                 => 'nullable|string',
            'produits'              => 'required|array|min:1',
            'produits.*.produit_id' => 'required|exists:produits,id',
            'produits.*.quantite'   => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        $montant = collect($request->produits)->sum(fn($l) => $l['quantite'] * $l['prix_unitaire']);

        $commande->update([
            'fournisseur_id'        => $request->fournisseur_id,
            'date_commande'         => $request->date_commande,
            'date_livraison_prevue' => $request->date_livraison_prevue,
            'montant_total'         => $montant,
            'notes'                 => $request->notes,
        ]);

        // Supprimer les anciennes lignes et recréer
        $commande->lignes()->delete();
        foreach ($request->produits as $ligne) {
            LigneCommandeFournisseur::create([
                'bon_commande_id'    => $commande->id,
                'produit_id'         => $ligne['produit_id'],
                'quantite_commandee' => $ligne['quantite'],
                'prix_unitaire'      => $ligne['prix_unitaire'],
                'montant'            => $ligne['quantite'] * $ligne['prix_unitaire'],
            ]);
        }

        return redirect()->route('appro.commandes.index')->with('success', 'Bon de commande modifié avec succès.');
    }

    public function destroy(BonCommandeFournisseur $commande)
    {
        $commande->delete();
        return redirect()->route('appro.commandes.index')->with('success', 'Bon de commande supprimé avec succès.');
    }

    public function imprimer(BonCommandeFournisseur $commande)
    {
        $commande->load('fournisseur', 'lignes.produit', 'user');
        $pdf = Pdf::loadView('pdf.bon-commande-fournisseur', compact('commande'));
        return $pdf->stream('BCF-' . $commande->numero . '.pdf');
    }

    public function imprimerReception(BonCommandeFournisseur $commande)
    {
        $commande->load('fournisseur', 'lignes.produit', 'user');
        $pdf = Pdf::loadView('pdf.bon-reception', compact('commande'));
        return $pdf->stream('BR-' . $commande->numero . '.pdf');
    }
}
