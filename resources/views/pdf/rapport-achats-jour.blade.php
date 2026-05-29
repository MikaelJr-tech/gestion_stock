<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f0f0f0; border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #ccc; padding: 6px 8px; }
        .total-row { background: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ÉTAT DES ACHATS</h1>
        <p>Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° BCF</th>
                <th>Fournisseur</th>
                <th>Statut</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td>{{ $commande->numero }}</td>
                <td>{{ $commande->fournisseur->nom }}</td>
                <td>{{ $commande->statut }}</td>
                <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align:right;">TOTAL :</td>
                <td>{{ number_format($total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer"><p>Imprimé le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
