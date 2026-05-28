<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilleProduit extends Model
{
    use BelongsToTenant;

    protected $table = 'familles_produits';

    protected $fillable = [
        'tenant_id',
        'nom',
        'description',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class, 'famille_id');
    }
}
