<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieClient extends Model
{
    use BelongsToTenant;

    protected $table = 'categories_clients';

    protected $fillable = [
        'tenant_id',
        'nom',
        'remise_default',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'categorie_id');
    }
}
