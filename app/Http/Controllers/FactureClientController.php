<?php

namespace App\Http\Controllers;

use App\Models\FactureClient;
use App\Models\CommandeClient;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureClientController extends Controller
{
    public function index()
    {
        $factures = FactureClient::with('client')->latest()->paginate(15);
        return view('ventes.factures.index', compact('factures'));
    }

    public function create()
    {
        $clients   = Client::all();
        $commandes = CommandeClient::where('statut', 'livrée')->doesntHave('facture')->get();
        $produits  = Produit::all();
        return view('ventes.factures.create', compact('clients', 'commandes', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'commande_id'  => 'nullable|exists:commandes_client,id',
            'date_facture' => 'required|date',
            'montant_ht'   => 'required|numeric|min:0',
            'tva'          => 'required|numeric|min:0|max:100',
            'type_vente'   => 'required|in:crédit,comptant',
        ]);

        $numero     = 'FC-' . date('Ymd') . '-' . str_pad(FactureClient::count() + 1, 4, '0', STR_PAD_LEFT);
        $montantTtc = $request->montant_ht * (1 + $request->tva / 100);
        $statut     = $request->type_vente === 'comptant' ? 'réglée' : 'impayée';
        $regle      = $request->type_vente === 'comptant' ? $montantTtc : 0;

        FactureClient::create([
            'client_id'     => $request->client_id,
            'commande_id'   => $request->commande_id,
            'user_id'       => auth()->id(),
            'numero'        => $numero,
            'date_facture'  => $request->date_facture,
            'montant_ht'    => $request->montant_ht,
            'tva'           => $request->tva,
            'montant_ttc'   => $montantTtc,
            'montant_regle' => $regle,
            'statut'        => $statut,
            'type_vente'    => $request->type_vente,
        ]);

        return redirect()->route('ventes.factures.index')
            ->with('success', 'Facture créée avec succès.');
    }

    public function show(FactureClient $facture)
    {
        $facture->load('client', 'commande.lignes.produit');
        return view('ventes.factures.show', compact('facture'));
    }

    public function edit(FactureClient $facture)
    {
        $clients   = Client::all();
        $commandes = CommandeClient::where('statut', 'livrée')->get();
        return view('ventes.factures.edit', compact('facture', 'clients', 'commandes'));
    }

    public function update(Request $request, FactureClient $facture)
    {
        $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'date_facture' => 'required|date',
            'montant_ht'   => 'required|numeric|min:0',
            'tva'          => 'required|numeric|min:0|max:100',
            'type_vente'   => 'required|in:crédit,comptant',
        ]);

        $montantTtc = $request->montant_ht * (1 + $request->tva / 100);

        $facture->update([
            'client_id'    => $request->client_id,
            'commande_id'  => $request->commande_id ?? $facture->commande_id,
            'date_facture' => $request->date_facture,
            'montant_ht'   => $request->montant_ht,
            'tva'          => $request->tva,
            'montant_ttc'  => $montantTtc,
            'type_vente'   => $request->type_vente,
        ]);

        return redirect()->route('ventes.factures.index')
            ->with('success', 'Facture modifiée avec succès.');
    }

    public function destroy(FactureClient $facture)
    {
        ArchiveController::archiver('facture_client', $facture);
        $facture->delete();
        return redirect()->route('ventes.factures.index')
            ->with('success', 'Facture supprimée et archivée en XML.');
    }

    public function reglerFacture(Request $request, FactureClient $facture)
    {
        $request->validate([
            'montant_regle' => 'required|numeric|min:0.01',
        ]);

        $nouveauMontantRegle = $facture->montant_regle + $request->montant_regle;

        if ($nouveauMontantRegle >= $facture->montant_ttc) {
            $facture->update([
                'montant_regle' => $facture->montant_ttc,
                'statut'        => 'réglée',
            ]);
        } else {
            $facture->update([
                'montant_regle' => $nouveauMontantRegle,
                'statut'        => 'partielle',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Règlement enregistré avec succès.');
    }

    public function imprimer(FactureClient $facture)
    {
        $facture->load('client', 'commande.lignes.produit');
        $pdf = Pdf::loadView('pdf.facture-client', compact('facture'));
        return $pdf->stream('FC-' . $facture->numero . '.pdf');
    }
}
