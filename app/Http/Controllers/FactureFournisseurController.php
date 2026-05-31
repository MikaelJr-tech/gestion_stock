<?php

namespace App\Http\Controllers;

use App\Models\FactureFournisseur;
use App\Models\BonCommandeFournisseur;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureFournisseurController extends Controller
{
    public function index()
    {
        $factures = FactureFournisseur::with('fournisseur')->latest()->paginate(15);
        return view('appro.factures.index', compact('factures'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $commandes    = BonCommandeFournisseur::with('fournisseur')->get();
        return view('appro.factures.create', compact('fournisseurs', 'commandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id'  => 'required|exists:fournisseurs,id',
            'bon_commande_id' => 'nullable|exists:bons_commande_fournisseur,id',
            'date_facture'    => 'required|date',
            'date_echeance'   => 'nullable|date',
            'montant_ht'      => 'required|numeric|min:0',
            'tva'             => 'required|numeric|min:0|max:100',
        ]);

        $numero     = 'FF-' . date('Ymd') . '-' . str_pad(FactureFournisseur::count() + 1, 4, '0', STR_PAD_LEFT);
        $montantTtc = $request->montant_ht * (1 + $request->tva / 100);

        FactureFournisseur::create([
            'fournisseur_id'  => $request->fournisseur_id,
            'bon_commande_id' => $request->bon_commande_id,
            'user_id'         => auth()->id(),
            'numero'          => $numero,
            'date_facture'    => $request->date_facture,
            'date_echeance'   => $request->date_echeance,
            'montant_ht'      => $request->montant_ht,
            'tva'             => $request->tva,
            'montant_ttc'     => $montantTtc,
        ]);

        return redirect()->route('appro.factures.index')
            ->with('success', 'Facture fournisseur créée avec succès.');
    }

    public function show(FactureFournisseur $facture)
    {
        $facture->load('fournisseur', 'bonCommande.lignes.produit');
        return view('appro.factures.show', compact('facture'));
    }

    public function edit(FactureFournisseur $facture)
    {
        $fournisseurs = Fournisseur::all();
        $commandes    = BonCommandeFournisseur::with('fournisseur')->get();
        return view('appro.factures.edit', compact('facture', 'fournisseurs', 'commandes'));
    }

    public function update(Request $request, FactureFournisseur $facture)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_facture'   => 'required|date',
            'date_echeance'  => 'nullable|date',
            'montant_ht'     => 'required|numeric|min:0',
            'tva'            => 'required|numeric|min:0|max:100',
        ]);

        $montantTtc = $request->montant_ht * (1 + $request->tva / 100);

        $facture->update([
            'fournisseur_id'  => $request->fournisseur_id,
            'bon_commande_id' => $request->bon_commande_id ?? $facture->bon_commande_id,
            'date_facture'    => $request->date_facture,
            'date_echeance'   => $request->date_echeance,
            'montant_ht'      => $request->montant_ht,
            'tva'             => $request->tva,
            'montant_ttc'     => $montantTtc,
        ]);

        return redirect()->route('appro.factures.index')
            ->with('success', 'Facture modifiée avec succès.');
    }

    public function destroy(FactureFournisseur $facture)
    {
        ArchiveController::archiver('facture_fournisseur', $facture);
        $facture->delete();
        return redirect()->route('appro.factures.index')
            ->with('success', 'Facture supprimée et archivée en XML.');
    }

    public function reglerFacture(Request $request, FactureFournisseur $facture)
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

    public function imprimer(FactureFournisseur $facture)
    {
        $facture->load('fournisseur', 'bonCommande.lignes.produit');
        $pdf = Pdf::loadView('pdf.facture-fournisseur', compact('facture'));
        return $pdf->stream('FF-' . $facture->numero . '.pdf');
    }

    public function imprimerRecu(FactureFournisseur $facture)
    {
        $pdf = Pdf::loadView('pdf.recu-fournisseur', compact('facture'));
        return $pdf->stream('RECU-' . $facture->numero . '.pdf');
    }
}
