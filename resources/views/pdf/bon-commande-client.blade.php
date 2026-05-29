<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { color: #2563eb; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block { width: 48%; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #dbeafe; border: 1px solid #93c5fd; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .total-row { background: #dbeafe; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE COMMANDE CLIENT</h1>
        <p>N° {{ $commande->numero }}</p>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <p><strong>Client :</strong> {{ $commande->client->nom }}</p>
            <p><strong>Téléphone :</strong> {{ $commande->client->telephone ?? '-' }}</p>
            <p><strong>Adresse :</strong> {{ $commande->client->adresse ?? '-' }}</p>
        </div>
        <div class="info-block" style="text-align: right;">
            <p><strong>Date commande :</strong> {{ $commande->date_commande->format('d/m/Y') }}</p>
            <p><strong>Statut :</strong> {{ strtoupper($commande->statut) }}</p>
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
                <th>Remise</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->lignes as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->produit->unite }}</td>
                <td>{{ $ligne->quantite }}</td>
                <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                <td>{{ $ligne->remise }} %</td>
                <td>{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">TOTAL :</td>
                <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer"><p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
