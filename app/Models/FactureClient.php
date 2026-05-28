<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureClient extends Model
{
    use BelongsToTenant;

    protected $table = 'factures_client';

    protected $fillable = [
        'tenant_id',
        'commande_id',
        'client_id',
        'user_id',
        'numero',
        'date_facture',
        'montant_ht',
        'tva',
        'montant_ttc',
        'montant_regle',
        'statut',
        'type_vente',
    ];

    protected function casts(): array
    {
        return [
            'date_facture' => 'date',
            'montant_ht' => 'decimal:2',
            'montant_ttc' => 'decimal:2',
            'montant_regle' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(CommandeClient::class, 'commande_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resteAPayer(): float
    {
        return $this->montant_ttc - $this->montant_regle;
    }
}
