<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'nom_entreprise',
        'slug',
        'email',
        'telephone',
        'adresse',
        'statut',
        'date_expiration',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function famillesProduits(): HasMany
    {
        return $this->hasMany(FamilleProduit::class);
    }

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }

    public function fournisseurs(): HasMany
    {
        return $this->hasMany(Fournisseur::class);
    }

    public function categoriesClients(): HasMany
    {
        return $this->hasMany(CategorieClient::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function banques(): HasMany
    {
        return $this->hasMany(Banque::class);
    }

    public function bonsCommandeFournisseur(): HasMany
    {
        return $this->hasMany(BonCommandeFournisseur::class);
    }

    public function facturesFournisseur(): HasMany
    {
        return $this->hasMany(FactureFournisseur::class);
    }

    public function bonsEntree(): HasMany
    {
        return $this->hasMany(BonEntree::class);
    }

    public function commandesClient(): HasMany
    {
        return $this->hasMany(CommandeClient::class);
    }

    public function facturesClient(): HasMany
    {
        return $this->hasMany(FactureClient::class);
    }

    public function bonsSortie(): HasMany
    {
        return $this->hasMany(BonSortie::class);
    }

    public function versementsBanque(): HasMany
    {
        return $this->hasMany(VersementBanque::class);
    }
}
