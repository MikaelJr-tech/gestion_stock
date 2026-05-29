<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1d4ed8; padding-bottom: 10px; }
        .header h1 { color: #1d4ed8; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block { width: 48%; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #dbeafe; border: 1px solid #93c5fd; padding: 6px 8px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 6px 8px; }
        .total-section { margin-top: 15px; text-align: right; }
        .total-section table { width: 280px; margin-left: auto; }
        .statut-regle { color: #16a34a; font-weight: bold; }
        .statut-impaye { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE FOURNISSEUR</h1>
        <p>N° {{ $facture->numero }}</p>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <p><strong>Fournisseur :</strong> {{ $facture->fournisseur->nom }}</p>
            <p><strong>Téléphone :</strong> {{ $facture->fournisseur->telephone ?? '-' }}</p>
            <p><strong>N° Contribuable :</strong> {{ $facture->fournisseur->numero_contribuable ?? '-' }}</p>
        </div>
        <div class="info-block" style="text-align: right;">
            <p><strong>Date facture :</strong> {{ $facture->date_facture->format('d/m/Y') }}</p>
            <p><strong>Date échéance :</strong> {{ $facture->date_echeance?->format('d/m/Y') ?? '-' }}</p>
            <p><strong>Statut :</strong>
                <span class="{{ $facture->statut === 'réglée' ? 'statut-regle' : 'statut-impaye' }}">
                    {{ strtoupper($facture->statut) }}
                </span>
            </p>
        </div>
    </div>

    <div class="total-section">
        <table>
            <tr><td>Montant HT</td><td style="text-align:right;">{{ number_format($facture->montant_ht, 0, ',', ' ') }} FCFA</td></tr>
            <tr><td>TVA ({{ $facture->tva }}%)</td><td style="text-align:right;">{{ number_format($facture->montant_ttc - $facture->montant_ht, 0, ',', ' ') }} FCFA</td></tr>
            <tr style="font-weight:bold; background:#dbeafe;"><td>TOTAL TTC</td><td style="text-align:right;">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td></tr>
            <tr><td>Réglé</td><td style="text-align:right; color:#16a34a;">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</td></tr>
            <tr style="font-weight:bold;"><td>Reste à payer</td><td style="text-align:right; color:#dc2626;">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</td></tr>
        </table>
    </div>

    <p style="margin-top: 20px; font-size: 10px; color: #666; text-align: right;">
        Document généré le {{ now()->format('d/m/Y à H:i') }}
    </p>
</body>
</html>
