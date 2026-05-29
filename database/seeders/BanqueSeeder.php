<?php

namespace Database\Seeders;

use App\Models\Banque;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BanqueSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $banques = [
            [
                'nom'           => 'BICEC',
                'numero_compte' => '0001-12345-67890-12',
                'solde'         => 5000000,
            ],
            [
                'nom'           => 'Afriland First Bank',
                'numero_compte' => '0002-98765-43210-34',
                'solde'         => 3500000,
            ],
            [
                'nom'           => 'UBA Cameroun',
                'numero_compte' => '0003-11111-22222-56',
                'solde'         => 1500000,
            ],
        ];

        foreach ($banques as $data) {
            Banque::firstOrCreate(
                ['nom' => $data['nom'], 'tenant_id' => $tenant->id],
                array_merge($data, ['tenant_id' => $tenant->id])
            );
        }

        $this->command->info('✅ Banques créées avec succès.');
    }
}
