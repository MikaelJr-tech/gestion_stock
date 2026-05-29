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
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE RÉCEPTION</h1>
        <p>Réf. BCF : {{ $commande->numero }}</p>
    </div>

    <p><strong>Fournisseur :</strong> {{ $commande->fournisseur->nom }}</p>
    <p><strong>Date réception :</strong> {{ now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Qté commandée</th>
                <th>Qté reçue</th>
                <th>Écart</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->lignes as $ligne)
            <tr>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->quantite_commandee }}</td>
                <td>{{ $ligne->quantite_recue }}</td>
                <td>{{ $ligne->quantite_commandee - $ligne->quantite_recue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div>
            <p>Signature réceptionnaire :</p>
            <div style="margin-top: 30px; border-top: 1px solid #333; width: 150px;"></div>
        </div>
        <div>
            <p>Signature fournisseur :</p>
            <div style="margin-top: 30px; border-top: 1px solid #333; width: 150px;"></div>
        </div>
    </div>

    <div class="footer"><p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
