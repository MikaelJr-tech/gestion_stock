<?php

namespace Database\Seeders;

use App\Models\FamilleProduit;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class FamilleProduitSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $familles = [
            ['nom' => 'Boissons',        'description' => 'Eau, jus, sodas, bières'],
            ['nom' => 'Alimentaire',     'description' => 'Produits alimentaires secs et frais'],
            ['nom' => 'Hygiène',         'description' => 'Savons, shampooings, produits de nettoyage'],
            ['nom' => 'Électronique',    'description' => 'Appareils et accessoires électroniques'],
            ['nom' => 'Papeterie',       'description' => 'Fournitures de bureau et scolaires'],
            ['nom' => 'Cosmétiques',     'description' => 'Produits de beauté et soins'],
            ['nom' => 'Pharmaceutique',  'description' => 'Médicaments et produits de santé'],
        ];

        foreach ($familles as $famille) {
            FamilleProduit::firstOrCreate(
                ['nom' => $famille['nom'], 'tenant_id' => $tenant->id],
                ['description' => $famille['description'], 'tenant_id' => $tenant->id]
            );
        }

        $this->command->info('✅ Familles de produits créées avec succès.');
    }
}
