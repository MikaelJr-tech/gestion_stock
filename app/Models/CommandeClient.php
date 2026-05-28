<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CommandeClient extends Model
{
    use BelongsToTenant;

    protected $table = 'commandes_client';

    protected $fillable = [
        'tenant_id',
        'client_id',
        'user_id',
        'numero',
        'date_commande',
        'statut',
        'montant_total',
    ];

    protected function casts(): array
    {
        return [
            'date_commande' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommandeClient::class, 'commande_id');
    }

    public function facture(): HasOne
    {
        return $this->hasOne(FactureClient::class, 'commande_id');
    }
}
