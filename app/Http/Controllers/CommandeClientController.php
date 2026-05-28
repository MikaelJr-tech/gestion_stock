<?php

namespace App\Http\Controllers;

use App\Models\CommandeClient;
use App\Models\LigneCommandeClient;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeClientController extends Controller
{
    public function index()
    {
        $commandes = CommandeClient::with('client')->latest()->paginate(15);
        return view('ventes.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $clients  = Client::all();
        $produits = Produit::where('stock_actuel', '>', 0)->get();
        return view('ventes.commandes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'            => 'required|exists:clients,id',
            'date_commande'        => 'required|date',
            'produits'             => 'required|array|min:1',
            'produits.*.produit_id'=> 'required|exists:produits,id',
            'produits.*.quantite'  => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.remise'    => 'nullable|numeric|min:0|max:100',
        ]);

        $numero  = 'CC-' . date('Ymd') . '-' . str_pad(CommandeClient::count() + 1, 4, '0', STR_PAD_LEFT);
        $montant = collect($request->produits)->sum(function ($l) {
            $remise = $l['remise'] ?? 0;
            return $l['quantite'] * $l['prix_unitaire'] * (1 - $remise / 100);
        });

        $commande = CommandeClient::create([
            'client_id'     => $request->client_id,
            'user_id'       => auth()->id(),
            'numero'        => $numero,
            'date_commande' => $request->date_commande,
            'montant_total' => $montant,
        ]);

        foreach ($request->produits as $ligne) {
            $remise  = $ligne['remise'] ?? 0;
            $montantL = $ligne['quantite'] * $ligne['prix_unitaire'] * (1 - $remise / 100);

            LigneCommandeClient::create([
                'commande_id'   => $commande->id,
                'produit_id'    => $ligne['produit_id'],
                'quantite'      => $ligne['quantite'],
                'prix_unitaire' => $ligne['prix_unitaire'],
                'remise'        => $remise,
                'montant'       => $montantL,
            ]);
        }

        return redirect()->route('ventes.commandes.index')->with('success', 'Commande créée avec succès.');
    }

    public function show(CommandeClient $commande)
    {
        $commande->load('client', 'lignes.produit', 'user');
        return view('ventes.commandes.show', compact('commande'));
    }

    public function edit(CommandeClient $commande)
    {
        $clients  = Client::all();
        $produits = Produit::all();
        $commande->load('lignes.produit');
        return view('ventes.commandes.edit', compact('commande', 'clients', 'produits'));
    }

    public function update(Request $request, CommandeClient $commande)
    {
        $request->validate([
            'client_id'             => 'required|exists:clients,id',
            'date_commande'         => 'required|date',
            'produits'              => 'required|array|min:1',
            'produits.*.produit_id' => 'required|exists:produits,id',
            'produits.*.quantite'   => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.remise'     => 'nullable|numeric|min:0|max:100',
        ]);

        $montant = collect($request->produits)->sum(function ($l) {
            $remise = $l['remise'] ?? 0;
            return $l['quantite'] * $l['prix_unitaire'] * (1 - $remise / 100);
        });

        $commande->update([
            'client_id'     => $request->client_id,
            'date_commande' => $request->date_commande,
            'montant_total' => $montant,
        ]);

        $commande->lignes()->delete();

        foreach ($request->produits as $ligne) {
            $remise   = $ligne['remise'] ?? 0;
            $montantL = $ligne['quantite'] * $ligne['prix_unitaire'] * (1 - $remise / 100);

            LigneCommandeClient::create([
                'commande_id'   => $commande->id,
                'produit_id'    => $ligne['produit_id'],
                'quantite'      => $ligne['quantite'],
                'prix_unitaire' => $ligne['prix_unitaire'],
                'remise'        => $remise,
                'montant'       => $montantL,
            ]);
        }

        return redirect()->route('ventes.commandes.index')->with('success', 'Commande modifiée avec succès.');
    }

    public function destroy(CommandeClient $commande)
    {
        $commande->delete();
        return redirect()->route('ventes.commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    public function livrer(CommandeClient $commande)
    {
        foreach ($commande->lignes as $ligne) {
            $ligne->produit->decrement('stock_actuel', $ligne->quantite);
        }

        $commande->update(['statut' => 'livrée']);
        return redirect()->back()->with('success', 'Commande livrée et stock mis à jour.');
    }

    public function imprimer(CommandeClient $commande)
    {
        $commande->load('client', 'lignes.produit');
        $pdf = Pdf::loadView('pdf.bon-commande-client', compact('commande'));
        return $pdf->stream('CC-' . $commande->numero . '.pdf');
    }

    public function imprimerLivraison(CommandeClient $commande)
    {
        $commande->load('client', 'lignes.produit');
        $pdf = Pdf::loadView('pdf.bon-livraison-client', compact('commande'));
        return $pdf->stream('BL-' . $commande->numero . '.pdf');
    }
}
