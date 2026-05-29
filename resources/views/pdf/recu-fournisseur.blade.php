<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .recu { border: 2px solid #333; padding: 20px; max-width: 400px; margin: auto; }
        .header { text-align: center; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 15px; }
        .row { display: flex; justify-content: space-between; margin: 8px 0; }
        .total { font-size: 16px; font-weight: bold; text-align: center; margin-top: 15px; border-top: 1px solid #333; padding-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="recu">
        <div class="header">
            <h2 style="margin:0;">REÇU DE PAIEMENT</h2>
            <p style="margin:5px 0;">Facture N° {{ $facture->numero }}</p>
        </div>

        <div class="row"><span>Fournisseur :</span><span><strong>{{ $facture->fournisseur->nom }}</strong></span></div>
        <div class="row"><span>Date :</span><span>{{ now()->format('d/m/Y') }}</span></div>
        <div class="row"><span>Montant facture :</span><span>{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</span></div>
        <div class="row"><span>Montant réglé :</span><span style="color:#16a34a;font-weight:bold;">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</span></div>
        <div class="row"><span>Reste à payer :</span><span style="color:#dc2626;font-weight:bold;">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</span></div>

        <div class="total">
            STATUT : {{ strtoupper($facture->statut) }}
        </div>

        <div class="footer">
            <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>
