<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\FamilleProduit;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $tenant     = Tenant::first();
        $boissons   = FamilleProduit::where('nom', 'Boissons')->first();
        $aliment    = FamilleProduit::where('nom', 'Alimentaire')->first();
        $hygiene    = FamilleProduit::where('nom', 'Hygiène')->first();
        $cosmetique = FamilleProduit::where('nom', 'Cosmétiques')->first();
        $papeterie  = FamilleProduit::where('nom', 'Papeterie')->first();

        $produits = [
            // Boissons — produit père
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $boissons->id,
                'produit_parent_id'=> null,
                'code'             => 'BOI-001',
                'nom'              => 'Eau minérale 500ml (Carton)',
                'unite'            => 'carton',
                'prix_achat'       => 3500,
                'prix_vente'       => 4500,
                'stock_actuel'     => 50,
                'stock_minimum'    => 10,
                'type'             => 'père',
                'facteur_fraction' => 24,
            ],
            // Boissons — produit fils
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $boissons->id,
                'produit_parent_id'=> null, // sera mis à jour après
                'code'             => 'BOI-001-U',
                'nom'              => 'Eau minérale 500ml (Unité)',
                'unite'            => 'bouteille',
                'prix_achat'       => 150,
                'prix_vente'       => 200,
                'stock_actuel'     => 1200,
                'stock_minimum'    => 50,
                'type'             => 'fils',
                'facteur_fraction' => 1,
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $boissons->id,
                'produit_parent_id'=> null,
                'code'             => 'BOI-002',
                'nom'              => 'Coca-Cola 33cl',
                'unite'            => 'bouteille',
                'prix_achat'       => 350,
                'prix_vente'       => 500,
                'stock_actuel'     => 200,
                'stock_minimum'    => 30,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $boissons->id,
                'produit_parent_id'=> null,
                'code'             => 'BOI-003',
                'nom'              => 'Bière Castel 65cl',
                'unite'            => 'bouteille',
                'prix_achat'       => 600,
                'prix_vente'       => 800,
                'stock_actuel'     => 150,
                'stock_minimum'    => 20,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            // Alimentaire
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $aliment->id,
                'produit_parent_id'=> null,
                'code'             => 'ALI-001',
                'nom'              => 'Riz parfumé 5kg',
                'unite'            => 'sac',
                'prix_achat'       => 3500,
                'prix_vente'       => 4500,
                'stock_actuel'     => 80,
                'stock_minimum'    => 15,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $aliment->id,
                'produit_parent_id'=> null,
                'code'             => 'ALI-002',
                'nom'              => 'Huile de palme 1L',
                'unite'            => 'litre',
                'prix_achat'       => 1200,
                'prix_vente'       => 1500,
                'stock_actuel'     => 5,
                'stock_minimum'    => 10,
                'type'             => 'simple',
                'facteur_fraction' => 1,
                'date_expiration'  => now()->addMonths(6),
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $aliment->id,
                'produit_parent_id'=> null,
                'code'             => 'ALI-003',
                'nom'              => 'Farine de blé 1kg',
                'unite'            => 'kg',
                'prix_achat'       => 800,
                'prix_vente'       => 1000,
                'stock_actuel'     => 60,
                'stock_minimum'    => 10,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            // Hygiène
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $hygiene->id,
                'produit_parent_id'=> null,
                'code'             => 'HYG-001',
                'nom'              => 'Savon Omo 250g',
                'unite'            => 'pièce',
                'prix_achat'       => 300,
                'prix_vente'       => 450,
                'stock_actuel'     => 100,
                'stock_minimum'    => 20,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $hygiene->id,
                'produit_parent_id'=> null,
                'code'             => 'HYG-002',
                'nom'              => 'Lessive Ariel 1kg',
                'unite'            => 'boite',
                'prix_achat'       => 1800,
                'prix_vente'       => 2500,
                'stock_actuel'     => 3,
                'stock_minimum'    => 8,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            // Cosmétiques
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $cosmetique->id,
                'produit_parent_id'=> null,
                'code'             => 'COS-001',
                'nom'              => 'Crème hydratante Nivea 200ml',
                'unite'            => 'tube',
                'prix_achat'       => 1500,
                'prix_vente'       => 2000,
                'stock_actuel'     => 45,
                'stock_minimum'    => 10,
                'type'             => 'simple',
                'facteur_fraction' => 1,
            ],
            // Papeterie
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $papeterie->id,
                'produit_parent_id'=> null,
                'code'             => 'PAP-001',
                'nom'              => 'Stylo Bic (boite de 50)',
                'unite'            => 'boite',
                'prix_achat'       => 2000,
                'prix_vente'       => 3000,
                'stock_actuel'     => 30,
                'stock_minimum'    => 5,
                'type'             => 'père',
                'facteur_fraction' => 50,
            ],
            [
                'tenant_id'        => $tenant->id,
                'famille_id'       => $papeterie->id,
                'produit_parent_id'=> null,
                'code'             => 'PAP-001-U',
                'nom'              => 'Stylo Bic (Unité)',
                'unite'            => 'pièce',
                'prix_achat'       => 50,
                'prix_vente'       => 75,
                'stock_actuel'     => 1500,
                'stock_minimum'    => 50,
                'type'             => 'fils',
                'facteur_fraction' => 1,
            ],
        ];

        foreach ($produits as $data) {
            Produit::firstOrCreate(
                ['code' => $data['code'], 'tenant_id' => $tenant->id],
                $data
            );
        }

        // Lier les produits fils à leurs pères
        $pere1 = Produit::where('code', 'BOI-001')->first();
        $fils1 = Produit::where('code', 'BOI-001-U')->first();
        if ($pere1 && $fils1) {
            $fils1->update(['produit_parent_id' => $pere1->id]);
        }

        $pere2 = Produit::where('code', 'PAP-001')->first();
        $fils2 = Produit::where('code', 'PAP-001-U')->first();
        if ($pere2 && $fils2) {
            $fils2->update(['produit_parent_id' => $pere2->id]);
        }

        $this->command->info('✅ Produits créés avec succès.');
    }
}
