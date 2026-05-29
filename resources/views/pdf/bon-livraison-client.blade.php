<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { color: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #dcfce7; border: 1px solid #86efac; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .signatures { display: flex; justify-content: space-between; margin-top: 40px; }
        .signature-block { text-align: center; width: 45%; }
        .signature-line { border-top: 1px solid #333; margin-top: 30px; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE LIVRAISON</h1>
        <p>Réf. commande : {{ $commande->numero }}</p>
    </div>

    <p><strong>Client :</strong> {{ $commande->client->nom }}</p>
    <p><strong>Adresse :</strong> {{ $commande->client->adresse ?? '-' }}</p>
    <p><strong>Date livraison :</strong> {{ now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Unité</th>
                <th>Quantité livrée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->lignes as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->produit->unite }}</td>
                <td>{{ $ligne->quantite }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <div class="signature-block">
            <p>Signature livreur</p>
            <div class="signature-line"></div>
        </div>
        <div class="signature-block">
            <p>Signature client</p>
            <div class="signature-line"></div>
        </div>
    </div>

    <div class="footer"><p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
