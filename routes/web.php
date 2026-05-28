<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilleProduitController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CategorieClientController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\VersementBanqueController;
use App\Http\Controllers\BonCommandeFournisseurController;
use App\Http\Controllers\FactureFournisseurController;
use App\Http\Controllers\BonEntreeController;
use App\Http\Controllers\CommandeClientController;
use App\Http\Controllers\FactureClientController;
use App\Http\Controllers\BonSortieController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupeController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── STRUCTURE ───────────────────────────────────────────────
    Route::resource('familles', FamilleProduitController::class);
    Route::get('produits/{produit}/fractionner', [ProduitController::class, 'fractionner'])->name('produits.fractionner');
    Route::resource('produits', ProduitController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('categories', CategorieClientController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('banques', BanqueController::class);
    Route::resource('versements', VersementBanqueController::class);

    // ─── APPROVISIONNEMENTS ──────────────────────────────────────
    Route::prefix('approvisionnements')->name('appro.')->group(function () {

        // Bons de commande fournisseur
        Route::resource('commandes', BonCommandeFournisseurController::class)
            ->names('commandes');
        Route::get('commandes/{commande}/imprimer', [BonCommandeFournisseurController::class, 'imprimer'])
            ->name('commandes.imprimer');
        Route::get('commandes/{commande}/imprimer-reception', [BonCommandeFournisseurController::class, 'imprimerReception'])
            ->name('commandes.imprimer-reception');

        // Factures fournisseur
        Route::resource('factures', FactureFournisseurController::class)
            ->names('factures');
        Route::post('factures/{facture}/regler', [FactureFournisseurController::class, 'reglerFacture'])
            ->name('factures.regler');
        Route::get('factures/{facture}/imprimer', [FactureFournisseurController::class, 'imprimer'])
            ->name('factures.imprimer');
        Route::get('factures/{facture}/imprimer-recu', [FactureFournisseurController::class, 'imprimerRecu'])
            ->name('factures.imprimer-recu');

        // Bons d'entrée (dons)
        Route::resource('bons-entree', BonEntreeController::class)
            ->names('bons-entree');
        Route::get('bons-entree/{bonEntree}/imprimer', [BonEntreeController::class, 'imprimer'])
            ->name('bons-entree.imprimer');
    });

    // ─── VENTES ──────────────────────────────────────────────────
    Route::prefix('ventes')->name('ventes.')->group(function () {

        // Commandes client
        Route::resource('commandes', CommandeClientController::class)
            ->names('commandes');
        Route::post('commandes/{commande}/livrer', [CommandeClientController::class, 'livrer'])
            ->name('commandes.livrer');
        Route::get('commandes/{commande}/imprimer', [CommandeClientController::class, 'imprimer'])
            ->name('commandes.imprimer');
        Route::get('commandes/{commande}/imprimer-livraison', [CommandeClientController::class, 'imprimerLivraison'])
            ->name('commandes.imprimer-livraison');

        // Factures client
        Route::resource('factures', FactureClientController::class)
            ->names('factures');
        Route::post('factures/{facture}/regler', [FactureClientController::class, 'reglerFacture'])
            ->name('factures.regler');
        Route::get('factures/{facture}/imprimer', [FactureClientController::class, 'imprimer'])
            ->name('factures.imprimer');

        // Bons de sortie
        Route::resource('bons-sortie', BonSortieController::class)
            ->names('bons-sortie');
        Route::get('bons-sortie/{bonSortie}/imprimer', [BonSortieController::class, 'imprimer'])
            ->name('bons-sortie.imprimer');
    });

    // ─── RAPPORTS ────────────────────────────────────────────────
    Route::prefix('rapports')->name('rapports.')->group(function () {
        Route::get('achats-jour',       [RapportController::class, 'achatsJour'])->name('achats-jour');
        Route::get('achats-annuel',     [RapportController::class, 'achatsAnnuel'])->name('achats-annuel');
        Route::get('ventes-jour',       [RapportController::class, 'ventesJour'])->name('ventes-jour');
        Route::get('ventes-annuel',     [RapportController::class, 'ventesAnnuel'])->name('ventes-annuel');
        Route::get('versements-banque', [RapportController::class, 'versementsBanque'])->name('versements-banque');
        Route::get('imprimer-achats-jour',  [RapportController::class, 'imprimerAchatsJour'])->name('imprimer-achats-jour');
        Route::get('imprimer-ventes-jour',  [RapportController::class, 'imprimerVentesJour'])->name('imprimer-ventes-jour');
    });

    // ─── GESTION UTILISATEURS ────────────────────────────────────
    Route::resource('utilisateurs', UserController::class);
    Route::resource('groupes', GroupeController::class);
});

require __DIR__ . '/auth.php';
