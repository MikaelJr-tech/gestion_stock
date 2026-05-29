<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { color: #16a34a; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block { width: 48%; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #dcfce7; border: 1px solid #86efac; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .total-section { margin-top: 15px; text-align: right; }
        .total-section table { width: 280px; margin-left: auto; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE CLIENT</h1>
        <p>N° {{ $facture->numero }}</p>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <p><strong>Client :</strong> {{ $facture->client->nom }}</p>
            <p><strong>Téléphone :</strong> {{ $facture->client->telephone ?? '-' }}</p>
            <p><strong>Adresse :</strong> {{ $facture->client->adresse ?? '-' }}</p>
        </div>
        <div class="info-block" style="text-align: right;">
            <p><strong>Date facture :</strong> {{ $facture->date_facture->format('d/m/Y') }}</p>
            <p><strong>Type vente :</strong> {{ strtoupper($facture->type_vente) }}</p>
            <p><strong>Statut :</strong> {{ strtoupper($facture->statut) }}</p>
        </div>
    </div>

    @if($facture->commande)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Qté</th>
                <th>Prix unitaire</th>
                <th>Remise</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture->commande->lignes as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                <td>{{ $ligne->remise }} %</td>
                <td>{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="total-section">
        <table>
            <tr><td>Montant HT</td><td style="text-align:right;">{{ number_format($facture->montant_ht, 0, ',', ' ') }} FCFA</td></tr>
            <tr><td>TVA ({{ $facture->tva }}%)</td><td style="text-align:right;">{{ number_format($facture->montant_ttc - $facture->montant_ht, 0, ',', ' ') }} FCFA</td></tr>
            <tr style="font-weight:bold; background:#dcfce7;"><td>TOTAL TTC</td><td style="text-align:right;">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td></tr>
            <tr><td>Réglé</td><td style="text-align:right; color:#16a34a;">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</td></tr>
            <tr style="font-weight:bold;"><td>Reste à payer</td><td style="text-align:right; color:#dc2626;">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</td></tr>
        </table>
    </div>

    <p style="margin-top: 20px; font-size: 10px; color: #666; text-align: right;">
        Document généré le {{ now()->format('d/m/Y à H:i') }}
    </p>
</body>
</html>
