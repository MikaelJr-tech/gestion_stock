<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #7c3aed; padding-bottom: 10px; }
        .header h1 { color: #7c3aed; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #ede9fe; border: 1px solid #c4b5fd; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON D'ENTRÉE</h1>
        <p>N° {{ $bonEntree->numero }} — Type : {{ strtoupper($bonEntree->type) }}</p>
    </div>

    <p><strong>Source / Donateur :</strong> {{ $bonEntree->source ?? '-' }}</p>
    <p><strong>Date d'entrée :</strong> {{ $bonEntree->date_entree->format('d/m/Y') }}</p>
    <p><strong>Enregistré par :</strong> {{ $bonEntree->user->name }}</p>
    @if($bonEntree->notes)
    <p><strong>Notes :</strong> {{ $bonEntree->notes }}</p>
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
            @foreach($bonEntree->lignes as $i => $ligne)
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
