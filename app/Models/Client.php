<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'categorie_id',
        'nom',
        'telephone',
        'email',
        'adresse',
        'solde',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieClient::class, 'categorie_id');
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(CommandeClient::class);
    }

    public function factures(): HasMany
    {
        return $this->hasMany(FactureClient::class);
    }
}
