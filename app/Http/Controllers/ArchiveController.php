<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ArchiveController extends Controller
{
    // ─── Liste des archives ───────────────────────────────────────
    public function index()
    {
        $fichiers = collect(Storage::files('archives'))
            ->map(function ($path) {
                return [
                    'nom'      => basename($path),
                    'path'     => $path,
                    'taille'   => Storage::size($path),
                    'date'     => date('d/m/Y H:i:s', Storage::lastModified($path)),
                ];
            })
            ->sortByDesc('date')
            ->values();

        return view('archives.index', compact('fichiers'));
    }

    // ─── Télécharger une archive ──────────────────────────────────
    public function telecharger($nom)
    {
        $path = 'archives/' . $nom;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return Storage::download($path);
    }

    // ─── Supprimer une archive ────────────────────────────────────
    public function supprimerArchive($nom)
    {
        Storage::delete('archives/' . $nom);
        return redirect()->route('archives.index')
            ->with('success', 'Archive supprimée.');
    }

    // ─── Restaurer depuis une archive ────────────────────────────
    public function restaurer(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xml',
        ]);

        $contenu = file_get_contents($request->file('fichier')->getRealPath());

        try {
            $xml = new SimpleXMLElement($contenu);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Fichier XML invalide.');
        }

        $type   = (string) $xml->type;
        $modele = $this->getModele($type);

        if (!$modele) {
            return redirect()->back()->with('error', 'Type d\'archive inconnu : ' . $type);
        }

        $restored = 0;

        foreach ($xml->enregistrements->enregistrement as $enreg) {
            $data = [];
            foreach ($enreg->children() as $key => $value) {
                $data[$key] = (string) $value === 'NULL' ? null : (string) $value;
            }

            // Retirer l'id pour laisser Laravel en créer un nouveau
            unset($data['id']);

            try {
                $modele::create($data);
                $restored++;
            } catch (\Exception $e) {
                // Ignorer les doublons
                continue;
            }
        }

        return redirect()->route('archives.index')
            ->with('success', $restored . ' enregistrement(s) restauré(s) avec succès.');
    }

    // ─── Méthode statique : archiver avant suppression ────────────
    public static function archiver(string $type, $objet): string
    {
        $xml  = new SimpleXMLElement('<archive/>');
        $xml->addChild('type', $type);
        $xml->addChild('date_suppression', now()->toISOString());
        $xml->addChild('supprime_par', auth()->user()->name ?? 'Système');

        $enregs = $xml->addChild('enregistrements');
        $enreg  = $enregs->addChild('enregistrement');

        // Données de l'objet principal
        foreach ($objet->toArray() as $key => $value) {
            if (!is_array($value)) {
                $enreg->addChild($key, is_null($value) ? 'NULL' : htmlspecialchars((string)$value));
            }
        }

        // Relations (sous-éléments)
        if (method_exists($objet, 'lignes')) {
            $lignesNode = $xml->addChild('lignes');
            foreach ($objet->lignes as $ligne) {
                $ligneNode = $lignesNode->addChild('ligne');
                foreach ($ligne->toArray() as $key => $value) {
                    if (!is_array($value)) {
                        $ligneNode->addChild($key, is_null($value) ? 'NULL' : htmlspecialchars((string)$value));
                    }
                }
            }
        }

        $nom  = $type . '_' . $objet->id . '_' . now()->format('Ymd_His') . '.xml';
        Storage::put('archives/' . $nom, $xml->asXML());

        return $nom;
    }

    private function getModele(string $type): ?string
    {
        $map = [
            'produit'                   => \App\Models\Produit::class,
            'famille_produit'           => \App\Models\FamilleProduit::class,
            'fournisseur'               => \App\Models\Fournisseur::class,
            'client'                    => \App\Models\Client::class,
            'categorie_client'          => \App\Models\CategorieClient::class,
            'banque'                    => \App\Models\Banque::class,
            'bon_commande_fournisseur'  => \App\Models\BonCommandeFournisseur::class,
            'facture_fournisseur'       => \App\Models\FactureFournisseur::class,
            'bon_entree'                => \App\Models\BonEntree::class,
            'commande_client'           => \App\Models\CommandeClient::class,
            'facture_client'            => \App\Models\FactureClient::class,
            'bon_sortie'                => \App\Models\BonSortie::class,
        ];

        return $map[$type] ?? null;
    }
}
