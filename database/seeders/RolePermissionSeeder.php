<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Définir toutes les permissions
        $permissions = [
            // Produits
            'produits.voir',
            'produits.creer',
            'produits.modifier',
            'produits.supprimer',

            // Familles
            'familles.voir',
            'familles.creer',
            'familles.modifier',
            'familles.supprimer',

            // Fournisseurs
            'fournisseurs.voir',
            'fournisseurs.creer',
            'fournisseurs.modifier',
            'fournisseurs.supprimer',

            // Clients
            'clients.voir',
            'clients.creer',
            'clients.modifier',
            'clients.supprimer',

            // Catégories clients
            'categories.voir',
            'categories.creer',
            'categories.modifier',
            'categories.supprimer',

            // Banques
            'banques.voir',
            'banques.creer',
            'banques.modifier',
            'banques.supprimer',

            // Versements
            'versements.voir',
            'versements.creer',
            'versements.modifier',
            'versements.supprimer',

            // Approvisionnements
            'appro.commandes.voir',
            'appro.commandes.creer',
            'appro.commandes.modifier',
            'appro.commandes.supprimer',
            'appro.commandes.imprimer',

            'appro.factures.voir',
            'appro.factures.creer',
            'appro.factures.modifier',
            'appro.factures.supprimer',
            'appro.factures.regler',
            'appro.factures.imprimer',

            'appro.bons-entree.voir',
            'appro.bons-entree.creer',
            'appro.bons-entree.modifier',
            'appro.bons-entree.supprimer',
            'appro.bons-entree.imprimer',

            // Ventes
            'ventes.commandes.voir',
            'ventes.commandes.creer',
            'ventes.commandes.modifier',
            'ventes.commandes.supprimer',
            'ventes.commandes.livrer',
            'ventes.commandes.imprimer',

            'ventes.factures.voir',
            'ventes.factures.creer',
            'ventes.factures.modifier',
            'ventes.factures.supprimer',
            'ventes.factures.regler',
            'ventes.factures.imprimer',

            'ventes.bons-sortie.voir',
            'ventes.bons-sortie.creer',
            'ventes.bons-sortie.modifier',
            'ventes.bons-sortie.supprimer',
            'ventes.bons-sortie.imprimer',

            // Rapports
            'rapports.achats',
            'rapports.ventes',
            'rapports.versements',
            'rapports.imprimer',

            // Utilisateurs & groupes
            'utilisateurs.voir',
            'utilisateurs.creer',
            'utilisateurs.modifier',
            'utilisateurs.supprimer',

            'groupes.voir',
            'groupes.creer',
            'groupes.modifier',
            'groupes.supprimer',
        ];

        // Créer toutes les permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Rôle Administrateur ──────────────────────────────────
        $admin = Role::firstOrCreate(['name' => 'Administrateur']);
        $admin->syncPermissions(Permission::all());

        // ── Rôle Gestionnaire ────────────────────────────────────
        $gestionnaire = Role::firstOrCreate(['name' => 'Gestionnaire']);
        $gestionnaire->syncPermissions([
            'produits.voir', 'produits.creer', 'produits.modifier',
            'familles.voir', 'familles.creer', 'familles.modifier',
            'fournisseurs.voir', 'fournisseurs.creer', 'fournisseurs.modifier',
            'clients.voir', 'clients.creer', 'clients.modifier',
            'categories.voir', 'categories.creer', 'categories.modifier',
            'banques.voir', 'versements.voir', 'versements.creer',
            'appro.commandes.voir', 'appro.commandes.creer', 'appro.commandes.modifier', 'appro.commandes.imprimer',
            'appro.factures.voir', 'appro.factures.creer', 'appro.factures.regler', 'appro.factures.imprimer',
            'appro.bons-entree.voir', 'appro.bons-entree.creer', 'appro.bons-entree.imprimer',
            'ventes.commandes.voir', 'ventes.commandes.creer', 'ventes.commandes.modifier',
            'ventes.commandes.livrer', 'ventes.commandes.imprimer',
            'ventes.factures.voir', 'ventes.factures.creer', 'ventes.factures.regler', 'ventes.factures.imprimer',
            'ventes.bons-sortie.voir', 'ventes.bons-sortie.creer', 'ventes.bons-sortie.imprimer',
            'rapports.achats', 'rapports.ventes', 'rapports.versements', 'rapports.imprimer',
        ]);

        // ── Rôle Caissier ────────────────────────────────────────
        $caissier = Role::firstOrCreate(['name' => 'Caissier']);
        $caissier->syncPermissions([
            'produits.voir',
            'clients.voir', 'clients.creer',
            'ventes.commandes.voir', 'ventes.commandes.creer', 'ventes.commandes.livrer', 'ventes.commandes.imprimer',
            'ventes.factures.voir', 'ventes.factures.creer', 'ventes.factures.regler', 'ventes.factures.imprimer',
            'rapports.ventes',
        ]);

        // ── Rôle Magasinier ──────────────────────────────────────
        $magasinier = Role::firstOrCreate(['name' => 'Magasinier']);
        $magasinier->syncPermissions([
            'produits.voir', 'produits.modifier',
            'familles.voir',
            'fournisseurs.voir',
            'appro.commandes.voir', 'appro.commandes.imprimer',
            'appro.bons-entree.voir', 'appro.bons-entree.creer', 'appro.bons-entree.imprimer',
            'ventes.bons-sortie.voir', 'ventes.bons-sortie.creer', 'ventes.bons-sortie.imprimer',
        ]);

        $this->command->info('✅ Rôles et permissions créés avec succès.');
    }
}
