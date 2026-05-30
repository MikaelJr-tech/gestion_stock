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

    // ─── DASHBOARD ───────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── FAMILLES ────────────────────────────────────────────────
    Route::middleware(['permission:familles.creer'])->group(function () {
        Route::get('familles/create', [FamilleProduitController::class, 'create'])->name('familles.create');
        Route::post('familles', [FamilleProduitController::class, 'store'])->name('familles.store');
    });
    Route::middleware(['permission:familles.voir'])->group(function () {
        Route::get('familles', [FamilleProduitController::class, 'index'])->name('familles.index');
        Route::get('familles/{famille}', [FamilleProduitController::class, 'show'])->name('familles.show');
    });
    Route::middleware(['permission:familles.modifier'])->group(function () {
        Route::get('familles/{famille}/edit', [FamilleProduitController::class, 'edit'])->name('familles.edit');
        Route::put('familles/{famille}', [FamilleProduitController::class, 'update'])->name('familles.update');
    });
    Route::middleware(['permission:familles.supprimer'])->group(function () {
        Route::delete('familles/{famille}', [FamilleProduitController::class, 'destroy'])->name('familles.destroy');
    });

    // ─── PRODUITS ────────────────────────────────────────────────
    Route::middleware(['permission:produits.creer'])->group(function () {
        Route::get('produits/create', [ProduitController::class, 'create'])->name('produits.create');
        Route::post('produits', [ProduitController::class, 'store'])->name('produits.store');
    });
    Route::middleware(['permission:produits.voir'])->group(function () {
        Route::get('produits', [ProduitController::class, 'index'])->name('produits.index');
        Route::get('produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');
        Route::get('produits/{produit}/fractionner', [ProduitController::class, 'fractionner'])->name('produits.fractionner');
    });
    Route::middleware(['permission:produits.modifier'])->group(function () {
        Route::get('produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
        Route::put('produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
    });
    Route::middleware(['permission:produits.supprimer'])->group(function () {
        Route::delete('produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
    });

    // ─── FOURNISSEURS ────────────────────────────────────────────
    Route::middleware(['permission:fournisseurs.creer'])->group(function () {
        Route::get('fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
        Route::post('fournisseurs', [FournisseurController::class, 'store'])->name('fournisseurs.store');
    });
    Route::middleware(['permission:fournisseurs.voir'])->group(function () {
        Route::get('fournisseurs', [FournisseurController::class, 'index'])->name('fournisseurs.index');
        Route::get('fournisseurs/{fournisseur}', [FournisseurController::class, 'show'])->name('fournisseurs.show');
    });
    Route::middleware(['permission:fournisseurs.modifier'])->group(function () {
        Route::get('fournisseurs/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
        Route::put('fournisseurs/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
    });
    Route::middleware(['permission:fournisseurs.supprimer'])->group(function () {
        Route::delete('fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');
    });

    // ─── CATÉGORIES CLIENTS ──────────────────────────────────────
    Route::middleware(['permission:categories.creer'])->group(function () {
        Route::get('categories/create', [CategorieClientController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategorieClientController::class, 'store'])->name('categories.store');
    });
    Route::middleware(['permission:categories.voir'])->group(function () {
        Route::get('categories', [CategorieClientController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategorieClientController::class, 'show'])->name('categories.show');
    });
    Route::middleware(['permission:categories.modifier'])->group(function () {
        Route::get('categories/{category}/edit', [CategorieClientController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategorieClientController::class, 'update'])->name('categories.update');
    });
    Route::middleware(['permission:categories.supprimer'])->group(function () {
        Route::delete('categories/{category}', [CategorieClientController::class, 'destroy'])->name('categories.destroy');
    });

    // ─── CLIENTS ─────────────────────────────────────────────────
    Route::middleware(['permission:clients.creer'])->group(function () {
        Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    });
    Route::middleware(['permission:clients.voir'])->group(function () {
        Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    });
    Route::middleware(['permission:clients.modifier'])->group(function () {
        Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    });
    Route::middleware(['permission:clients.supprimer'])->group(function () {
        Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });

    // ─── BANQUES ─────────────────────────────────────────────────
    Route::middleware(['permission:banques.creer'])->group(function () {
        Route::get('banques/create', [BanqueController::class, 'create'])->name('banques.create');
        Route::post('banques', [BanqueController::class, 'store'])->name('banques.store');
    });
    Route::middleware(['permission:banques.voir'])->group(function () {
        Route::get('banques', [BanqueController::class, 'index'])->name('banques.index');
        Route::get('banques/{banque}', [BanqueController::class, 'show'])->name('banques.show');
    });
    Route::middleware(['permission:banques.modifier'])->group(function () {
        Route::get('banques/{banque}/edit', [BanqueController::class, 'edit'])->name('banques.edit');
        Route::put('banques/{banque}', [BanqueController::class, 'update'])->name('banques.update');
    });
    Route::middleware(['permission:banques.supprimer'])->group(function () {
        Route::delete('banques/{banque}', [BanqueController::class, 'destroy'])->name('banques.destroy');
    });

    // ─── VERSEMENTS ──────────────────────────────────────────────
    Route::middleware(['permission:versements.creer'])->group(function () {
        Route::get('versements/create', [VersementBanqueController::class, 'create'])->name('versements.create');
        Route::post('versements', [VersementBanqueController::class, 'store'])->name('versements.store');
    });
    Route::middleware(['permission:versements.voir'])->group(function () {
        Route::get('versements', [VersementBanqueController::class, 'index'])->name('versements.index');
        Route::get('versements/{versement}', [VersementBanqueController::class, 'show'])->name('versements.show');
    });
    Route::middleware(['permission:versements.modifier'])->group(function () {
        Route::get('versements/{versement}/edit', [VersementBanqueController::class, 'edit'])->name('versements.edit');
        Route::put('versements/{versement}', [VersementBanqueController::class, 'update'])->name('versements.update');
    });
    Route::middleware(['permission:versements.supprimer'])->group(function () {
        Route::delete('versements/{versement}', [VersementBanqueController::class, 'destroy'])->name('versements.destroy');
    });

    // ─── APPROVISIONNEMENTS ──────────────────────────────────────
    Route::prefix('approvisionnements')->name('appro.')->group(function () {

        // Bons de commande fournisseur
        Route::middleware(['permission:appro.commandes.creer'])->group(function () {
            Route::get('commandes/create', [BonCommandeFournisseurController::class, 'create'])->name('commandes.create');
            Route::post('commandes', [BonCommandeFournisseurController::class, 'store'])->name('commandes.store');
        });
        Route::middleware(['permission:appro.commandes.voir'])->group(function () {
            Route::get('commandes', [BonCommandeFournisseurController::class, 'index'])->name('commandes.index');
            Route::get('commandes/{commande}', [BonCommandeFournisseurController::class, 'show'])->name('commandes.show');
        });
        Route::middleware(['permission:appro.commandes.modifier'])->group(function () {
            Route::get('commandes/{commande}/edit', [BonCommandeFournisseurController::class, 'edit'])->name('commandes.edit');
            Route::put('commandes/{commande}', [BonCommandeFournisseurController::class, 'update'])->name('commandes.update');
        });
        Route::middleware(['permission:appro.commandes.supprimer'])->group(function () {
            Route::delete('commandes/{commande}', [BonCommandeFournisseurController::class, 'destroy'])->name('commandes.destroy');
        });
        Route::middleware(['permission:appro.commandes.imprimer'])->group(function () {
            Route::get('commandes/{commande}/imprimer', [BonCommandeFournisseurController::class, 'imprimer'])->name('commandes.imprimer');
            Route::get('commandes/{commande}/imprimer-reception', [BonCommandeFournisseurController::class, 'imprimerReception'])->name('commandes.imprimer-reception');
        });

        // Factures fournisseur
        Route::middleware(['permission:appro.factures.creer'])->group(function () {
            Route::get('factures/create', [FactureFournisseurController::class, 'create'])->name('factures.create');
            Route::post('factures', [FactureFournisseurController::class, 'store'])->name('factures.store');
        });
        Route::middleware(['permission:appro.factures.voir'])->group(function () {
            Route::get('factures', [FactureFournisseurController::class, 'index'])->name('factures.index');
            Route::get('factures/{facture}', [FactureFournisseurController::class, 'show'])->name('factures.show');
        });
        Route::middleware(['permission:appro.factures.modifier'])->group(function () {
            Route::get('factures/{facture}/edit', [FactureFournisseurController::class, 'edit'])->name('factures.edit');
            Route::put('factures/{facture}', [FactureFournisseurController::class, 'update'])->name('factures.update');
        });
        Route::middleware(['permission:appro.factures.supprimer'])->group(function () {
            Route::delete('factures/{facture}', [FactureFournisseurController::class, 'destroy'])->name('factures.destroy');
        });
        Route::middleware(['permission:appro.factures.regler'])->group(function () {
            Route::post('factures/{facture}/regler', [FactureFournisseurController::class, 'reglerFacture'])->name('factures.regler');
        });
        Route::middleware(['permission:appro.factures.imprimer'])->group(function () {
            Route::get('factures/{facture}/imprimer', [FactureFournisseurController::class, 'imprimer'])->name('factures.imprimer');
            Route::get('factures/{facture}/imprimer-recu', [FactureFournisseurController::class, 'imprimerRecu'])->name('factures.imprimer-recu');
        });

        // Bons d'entrée
        Route::middleware(['permission:appro.bons-entree.creer'])->group(function () {
            Route::get('bons-entree/create', [BonEntreeController::class, 'create'])->name('bons-entree.create');
            Route::post('bons-entree', [BonEntreeController::class, 'store'])->name('bons-entree.store');
        });
        Route::middleware(['permission:appro.bons-entree.voir'])->group(function () {
            Route::get('bons-entree', [BonEntreeController::class, 'index'])->name('bons-entree.index');
            Route::get('bons-entree/{bonEntree}', [BonEntreeController::class, 'show'])->name('bons-entree.show');
        });
        Route::middleware(['permission:appro.bons-entree.modifier'])->group(function () {
            Route::get('bons-entree/{bonEntree}/edit', [BonEntreeController::class, 'edit'])->name('bons-entree.edit');
            Route::put('bons-entree/{bonEntree}', [BonEntreeController::class, 'update'])->name('bons-entree.update');
        });
        Route::middleware(['permission:appro.bons-entree.supprimer'])->group(function () {
            Route::delete('bons-entree/{bonEntree}', [BonEntreeController::class, 'destroy'])->name('bons-entree.destroy');
        });
        Route::middleware(['permission:appro.bons-entree.imprimer'])->group(function () {
            Route::get('bons-entree/{bonEntree}/imprimer', [BonEntreeController::class, 'imprimer'])->name('bons-entree.imprimer');
        });
    });

    // ─── VENTES ──────────────────────────────────────────────────
    Route::prefix('ventes')->name('ventes.')->group(function () {

        // Commandes client
        Route::middleware(['permission:ventes.commandes.creer'])->group(function () {
            Route::get('commandes/create', [CommandeClientController::class, 'create'])->name('commandes.create');
            Route::post('commandes', [CommandeClientController::class, 'store'])->name('commandes.store');
        });
        Route::middleware(['permission:ventes.commandes.voir'])->group(function () {
            Route::get('commandes', [CommandeClientController::class, 'index'])->name('commandes.index');
            Route::get('commandes/{commande}', [CommandeClientController::class, 'show'])->name('commandes.show');
        });
        Route::middleware(['permission:ventes.commandes.modifier'])->group(function () {
            Route::get('commandes/{commande}/edit', [CommandeClientController::class, 'edit'])->name('commandes.edit');
            Route::put('commandes/{commande}', [CommandeClientController::class, 'update'])->name('commandes.update');
        });
        Route::middleware(['permission:ventes.commandes.supprimer'])->group(function () {
            Route::delete('commandes/{commande}', [CommandeClientController::class, 'destroy'])->name('commandes.destroy');
        });
        Route::middleware(['permission:ventes.commandes.livrer'])->group(function () {
            Route::post('commandes/{commande}/livrer', [CommandeClientController::class, 'livrer'])->name('commandes.livrer');
        });
        Route::middleware(['permission:ventes.commandes.imprimer'])->group(function () {
            Route::get('commandes/{commande}/imprimer', [CommandeClientController::class, 'imprimer'])->name('commandes.imprimer');
            Route::get('commandes/{commande}/imprimer-livraison', [CommandeClientController::class, 'imprimerLivraison'])->name('commandes.imprimer-livraison');
        });

        // Factures client
        Route::middleware(['permission:ventes.factures.creer'])->group(function () {
            Route::get('factures/create', [FactureClientController::class, 'create'])->name('factures.create');
            Route::post('factures', [FactureClientController::class, 'store'])->name('factures.store');
        });
        Route::middleware(['permission:ventes.factures.voir'])->group(function () {
            Route::get('factures', [FactureClientController::class, 'index'])->name('factures.index');
            Route::get('factures/{facture}', [FactureClientController::class, 'show'])->name('factures.show');
        });
        Route::middleware(['permission:ventes.factures.modifier'])->group(function () {
            Route::get('factures/{facture}/edit', [FactureClientController::class, 'edit'])->name('factures.edit');
            Route::put('factures/{facture}', [FactureClientController::class, 'update'])->name('factures.update');
        });
        Route::middleware(['permission:ventes.factures.supprimer'])->group(function () {
            Route::delete('factures/{facture}', [FactureClientController::class, 'destroy'])->name('factures.destroy');
        });
        Route::middleware(['permission:ventes.factures.regler'])->group(function () {
            Route::post('factures/{facture}/regler', [FactureClientController::class, 'reglerFacture'])->name('factures.regler');
        });
        Route::middleware(['permission:ventes.factures.imprimer'])->group(function () {
            Route::get('factures/{facture}/imprimer', [FactureClientController::class, 'imprimer'])->name('factures.imprimer');
        });

        // Bons de sortie
        Route::middleware(['permission:ventes.bons-sortie.creer'])->group(function () {
            Route::get('bons-sortie/create', [BonSortieController::class, 'create'])->name('bons-sortie.create');
            Route::post('bons-sortie', [BonSortieController::class, 'store'])->name('bons-sortie.store');
        });
        Route::middleware(['permission:ventes.bons-sortie.voir'])->group(function () {
            Route::get('bons-sortie', [BonSortieController::class, 'index'])->name('bons-sortie.index');
            Route::get('bons-sortie/{bonSortie}', [BonSortieController::class, 'show'])->name('bons-sortie.show');
        });
        Route::middleware(['permission:ventes.bons-sortie.modifier'])->group(function () {
            Route::get('bons-sortie/{bonSortie}/edit', [BonSortieController::class, 'edit'])->name('bons-sortie.edit');
            Route::put('bons-sortie/{bonSortie}', [BonSortieController::class, 'update'])->name('bons-sortie.update');
        });
        Route::middleware(['permission:ventes.bons-sortie.supprimer'])->group(function () {
            Route::delete('bons-sortie/{bonSortie}', [BonSortieController::class, 'destroy'])->name('bons-sortie.destroy');
        });
        Route::middleware(['permission:ventes.bons-sortie.imprimer'])->group(function () {
            Route::get('bons-sortie/{bonSortie}/imprimer', [BonSortieController::class, 'imprimer'])->name('bons-sortie.imprimer');
        });
    });

    // ─── RAPPORTS ────────────────────────────────────────────────
    Route::prefix('rapports')->name('rapports.')->group(function () {
        Route::middleware(['permission:rapports.achats'])->group(function () {
            Route::get('achats-jour',   [RapportController::class, 'achatsJour'])->name('achats-jour');
            Route::get('achats-annuel', [RapportController::class, 'achatsAnnuel'])->name('achats-annuel');
        });
        Route::middleware(['permission:rapports.ventes'])->group(function () {
            Route::get('ventes-jour',   [RapportController::class, 'ventesJour'])->name('ventes-jour');
            Route::get('ventes-annuel', [RapportController::class, 'ventesAnnuel'])->name('ventes-annuel');
        });
        Route::middleware(['permission:rapports.versements'])->group(function () {
            Route::get('versements-banque', [RapportController::class, 'versementsBanque'])->name('versements-banque');
        });
        Route::middleware(['permission:rapports.imprimer'])->group(function () {
            Route::get('imprimer-achats-jour',  [RapportController::class, 'imprimerAchatsJour'])->name('imprimer-achats-jour');
            Route::get('imprimer-ventes-jour',  [RapportController::class, 'imprimerVentesJour'])->name('imprimer-ventes-jour');
        });
    });

    // ─── ADMINISTRATION ──────────────────────────────────────────
    Route::middleware(['role:Administrateur'])->group(function () {

        // Utilisateurs
        Route::get('utilisateurs/create', [UserController::class, 'create'])->name('utilisateurs.create');
        Route::post('utilisateurs', [UserController::class, 'store'])->name('utilisateurs.store');
        Route::get('utilisateurs', [UserController::class, 'index'])->name('utilisateurs.index');
        Route::get('utilisateurs/{utilisateur}', [UserController::class, 'show'])->name('utilisateurs.show');
        Route::get('utilisateurs/{utilisateur}/edit', [UserController::class, 'edit'])->name('utilisateurs.edit');
        Route::put('utilisateurs/{utilisateur}', [UserController::class, 'update'])->name('utilisateurs.update');
        Route::delete('utilisateurs/{utilisateur}', [UserController::class, 'destroy'])->name('utilisateurs.destroy');

        // Groupes
        Route::get('groupes/create', [GroupeController::class, 'create'])->name('groupes.create');
        Route::post('groupes', [GroupeController::class, 'store'])->name('groupes.store');
        Route::get('groupes', [GroupeController::class, 'index'])->name('groupes.index');
        Route::get('groupes/{groupe}', [GroupeController::class, 'show'])->name('groupes.show');
        Route::get('groupes/{groupe}/edit', [GroupeController::class, 'edit'])->name('groupes.edit');
        Route::put('groupes/{groupe}', [GroupeController::class, 'update'])->name('groupes.update');
        Route::delete('groupes/{groupe}', [GroupeController::class, 'destroy'])->name('groupes.destroy');
    });
});

require __DIR__.'/auth.php';
