<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { color: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #dcfce7; border: 1px solid #86efac; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .total-row { background: #dcfce7; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ÉTAT DES VENTES</h1>
        <p>Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Facture</th>
                <th>Client</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
            <tr>
                <td>{{ $facture->numero }}</td>
                <td>{{ $facture->client->nom }}</td>
                <td>{{ $facture->type_vente }}</td>
                <td>{{ $facture->statut }}</td>
                <td>{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align:right;">TOTAL :</td>
                <td>{{ number_format($total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer"><p>Imprimé le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
