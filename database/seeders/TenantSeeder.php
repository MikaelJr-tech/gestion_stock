<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'nom_entreprise' => 'Entreprise Demo SARL',
            'slug'           => 'demo',
            'email'          => 'demo@entreprise.com',
            'telephone'      => '+237 699 000 001',
            'adresse'        => 'Douala, Akwa, Cameroun',
            'statut'         => 'actif',
            'date_expiration'=> now()->addYear(),
        ]);
    }
}
