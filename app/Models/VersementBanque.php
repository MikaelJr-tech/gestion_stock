<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VersementBanque extends Model
{
    use BelongsToTenant;

    protected $table = 'versements_banque';

    protected $fillable = [
        'tenant_id',
        'banque_id',
        'user_id',
        'montant',
        'date_versement',
        'reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_versement' => 'date',
            'montant' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function banque(): BelongsTo
    {
        return $this->belongsTo(Banque::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
