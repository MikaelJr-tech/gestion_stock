<?php

namespace App\Http\Controllers;

use App\Models\BonCommandeFournisseur;
use App\Models\FactureClient;
use App\Models\VersementBanque;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    public function achatsJour(Request $request)
    {
        $date     = $request->get('date', today()->toDateString());
        $commandes = BonCommandeFournisseur::with('fournisseur')
            ->whereDate('date_commande', $date)
            ->get();
        $total = $commandes->sum('montant_total');
        return view('rapports.achats-jour', compact('commandes', 'total', 'date'));
    }

    public function achatsAnnuel(Request $request)
    {
        $annee    = $request->get('annee', date('Y'));
        $commandes = BonCommandeFournisseur::with('fournisseur')
            ->whereYear('date_commande', $annee)
            ->get();
        $total = $commandes->sum('montant_total');
        return view('rapports.achats-annuel', compact('commandes', 'total', 'annee'));
    }

    public function ventesJour(Request $request)
    {
        $date     = $request->get('date', today()->toDateString());
        $factures = FactureClient::with('client')
            ->whereDate('date_facture', $date)
            ->get();
        $total = $factures->sum('montant_ttc');
        return view('rapports.ventes-jour', compact('factures', 'total', 'date'));
    }

    public function ventesAnnuel(Request $request)
    {
        $annee    = $request->get('annee', date('Y'));
        $factures = FactureClient::with('client')
            ->whereYear('date_facture', $annee)
            ->get();
        $total = $factures->sum('montant_ttc');
        return view('rapports.ventes-annuel', compact('factures', 'total', 'annee'));
    }

    public function versementsBanque(Request $request)
    {
        $debut      = $request->get('debut', today()->startOfMonth()->toDateString());
        $fin        = $request->get('fin', today()->toDateString());
        $versements = VersementBanque::with('banque')
            ->whereBetween('date_versement', [$debut, $fin])
            ->get();
        $total = $versements->sum('montant');
        return view('rapports.versements-banque', compact('versements', 'total', 'debut', 'fin'));
    }

    public function imprimerAchatsJour(Request $request)
    {
        $date      = $request->get('date', today()->toDateString());
        $commandes = BonCommandeFournisseur::with('fournisseur')->whereDate('date_commande', $date)->get();
        $total     = $commandes->sum('montant_total');
        $pdf       = Pdf::loadView('pdf.rapport-achats-jour', compact('commandes', 'total', 'date'));
        return $pdf->stream('achats-' . $date . '.pdf');
    }

    public function imprimerVentesJour(Request $request)
    {
        $date     = $request->get('date', today()->toDateString());
        $factures = FactureClient::with('client')->whereDate('date_facture', $date)->get();
        $total    = $factures->sum('montant_ttc');
        $pdf      = Pdf::loadView('pdf.rapport-ventes-jour', compact('factures', 'total', 'date'));
        return $pdf->stream('ventes-' . $date . '.pdf');
    }
}
