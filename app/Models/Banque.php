<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banque extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'nom',
        'numero_compte',
        'solde',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function versements(): HasMany
    {
        return $this->hasMany(VersementBanque::class);
    }
}
