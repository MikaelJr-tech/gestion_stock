<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'nom',
        'telephone',
        'email',
        'adresse',
        'numero_contribuable',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function bonsCommande(): HasMany
    {
        return $this->hasMany(BonCommandeFournisseur::class);
    }

    public function factures(): HasMany
    {
        return $this->hasMany(FactureFournisseur::class);
    }
}
