<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\CommandeClient;
use App\Models\FactureClient;
use App\Models\FactureFournisseur;
use App\Models\BonCommandeFournisseur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produits'          => Produit::count(),
            'produits_rupture'        => Produit::whereColumn('stock_actuel', '<=', 'stock_minimum')->count(),
            'commandes_en_attente'    => CommandeClient::where('statut', 'en_attente')->count(),
            'factures_impayees'       => FactureClient::where('statut', 'impayée')->count(),
            'factures_fournisseur'    => FactureFournisseur::where('statut', 'impayée')->count(),
            'commandes_fournisseur'   => BonCommandeFournisseur::where('statut', 'en_attente')->count(),
        ];

        $produitsRupture = Produit::with('famille')
            ->whereColumn('stock_actuel', '<=', 'stock_minimum')
            ->take(5)
            ->get();

        $dernieresCommandes = CommandeClient::with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'produitsRupture', 'dernieresCommandes'));
    }
}
