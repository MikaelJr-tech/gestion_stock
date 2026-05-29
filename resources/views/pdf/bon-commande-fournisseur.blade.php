<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block { width: 48%; }
        .info-block p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f0f0f0; border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #ccc; padding: 6px 8px; }
        .total-row { background: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
        .badge { padding: 2px 8px; border-radius: 4px; background: #e0e7ff; color: #3730a3; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE COMMANDE FOURNISSEUR</h1>
        <p>N° {{ $commande->numero }}</p>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <p><strong>Fournisseur :</strong> {{ $commande->fournisseur->nom }}</p>
            <p><strong>Téléphone :</strong> {{ $commande->fournisseur->telephone ?? '-' }}</p>
            <p><strong>Adresse :</strong> {{ $commande->fournisseur->adresse ?? '-' }}</p>
        </div>
        <div class="info-block" style="text-align: right;">
            <p><strong>Date commande :</strong> {{ $commande->date_commande->format('d/m/Y') }}</p>
            <p><strong>Date livraison :</strong> {{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '-' }}</p>
            <p><strong>Statut :</strong> <span class="badge">{{ $commande->statut }}</span></p>
            <p><strong>Créé par :</strong> {{ $commande->user->name }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->lignes as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->produit->unite }}</td>
                <td>{{ $ligne->quantite_commandee }}</td>
                <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL :</td>
                <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    @if($commande->notes)
    <p style="margin-top: 15px;"><strong>Notes :</strong> {{ $commande->notes }}</p>
    @endif

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
