<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px; }
        .header h1 { color: #dc2626; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #fee2e2; border: 1px solid #fca5a5; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE SORTIE</h1>
        <p>N° {{ $bonSortie->numero }} — Motif : {{ strtoupper($bonSortie->motif) }}</p>
    </div>

    <p><strong>Date de sortie :</strong> {{ $bonSortie->date_sortie->format('d/m/Y') }}</p>
    <p><strong>Enregistré par :</strong> {{ $bonSortie->user->name }}</p>
    @if($bonSortie->notes)
    <p><strong>Notes :</strong> {{ $bonSortie->notes }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>Valeur unitaire</th>
                <th>Valeur totale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bonSortie->lignes as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->produit->nom }}</td>
                <td>{{ $ligne->produit->unite }}</td>
                <td>{{ $ligne->quantite }}</td>
                <td>{{ number_format($ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($ligne->quantite * $ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer"><p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p></div>
</body>
</html>
