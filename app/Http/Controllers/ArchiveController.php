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
                    'nom'    => basename($path),
                    'path'   => $path,
                    'taille' => Storage::size($path),
                    'date'   => date('d/m/Y H:i:s', Storage::lastModified($path)),
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

        $type = (string) $xml->type;

        // Cas spéciaux
        if ($type === 'groupe') {
            return $this->restaurerGroupe($xml);
        }

        if ($type === 'utilisateur') {
            return $this->restaurerUtilisateur($xml);
        }

        $modele = $this->getModele($type);

        if (!$modele) {
            return redirect()->back()
                ->with('error', 'Type d\'archive inconnu : ' . $type);
        }

        $restored = 0;

        foreach ($xml->enregistrements->enregistrement as $enreg) {
            $data = [];
            foreach ($enreg->children() as $key => $value) {
                $data[$key] = (string) $value === 'NULL' ? null : (string) $value;
            }
            unset($data['id']);

            try {
                $modele::create($data);
                $restored++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return redirect()->route('archives.index')
            ->with('success', $restored . ' enregistrement(s) restauré(s) avec succès.');
    }

    // ─── Restauration Utilisateur ─────────────────────────────────
    private function restaurerUtilisateur(SimpleXMLElement $xml): \Illuminate\Http\RedirectResponse
    {
        $restored = 0;

        foreach ($xml->enregistrements->enregistrement as $enreg) {
            $data = [];
            foreach ($enreg->children() as $key => $value) {
                $data[$key] = (string) $value === 'NULL' ? null : (string) $value;
            }
            unset($data['id']);

            // Éviter doublon d'email
            if (\App\Models\User::where('email', $data['email'])->exists()) {
                $data['email'] = 'restaure_' . time() . '_' . $data['email'];
            }

            // Garder seulement les colonnes valides de la table users
            $champsValides = ['name', 'email', 'password', 'tenant_id', 'email_verified_at', 'remember_token'];
            $data = array_intersect_key($data, array_flip($champsValides));

            try {
                \App\Models\User::create($data);
                $restored++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return redirect()->route('archives.index')
            ->with('success', $restored . ' utilisateur(s) restauré(s). ⚠️ Pensez à réassigner un rôle dans la section Utilisateurs.');
    }

    // ─── Restauration Groupe (Role Spatie) ────────────────────────
    private function restaurerGroupe(SimpleXMLElement $xml): \Illuminate\Http\RedirectResponse
    {
        $restored = 0;
        $nom      = (string) ($xml->enregistrements->enregistrement->name ?? '');

        if (!$nom) {
            return redirect()->back()->with('error', 'Fichier de groupe invalide.');
        }

        // Éviter doublon de nom
        if (\Spatie\Permission\Models\Role::where('name', $nom)->exists()) {
            $nom = $nom . '_restaure_' . time();
        }

        try {
            $role = \Spatie\Permission\Models\Role::create(['name' => $nom]);

            // Restaurer les permissions si disponibles
            if (isset($xml->permissions)) {
                $permNames = [];
                foreach ($xml->permissions->permission as $perm) {
                    $permNames[] = (string) $perm->name;
                }

                // Assigner seulement les permissions qui existent encore
                $permsExistantes = \Spatie\Permission\Models\Permission::whereIn('name', $permNames)
                    ->pluck('name')
                    ->toArray();

                if (!empty($permsExistantes)) {
                    $role->syncPermissions($permsExistantes);
                }
            }

            $restored++;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la restauration : ' . $e->getMessage());
        }

        $msg = $restored . ' groupe(s) restauré(s) avec leurs permissions.';

        // Afficher les utilisateurs qui avaient ce rôle
        if (isset($xml->utilisateurs)) {
            $users = [];
            foreach ($xml->utilisateurs->utilisateur as $u) {
                $users[] = (string) $u->name . ' (' . (string) $u->email . ')';
            }
            if (!empty($users)) {
                $msg .= ' Utilisateurs à réassigner : ' . implode(', ', $users);
            }
        }

        return redirect()->route('archives.index')->with('success', $msg);
    }

    // ─── Archiver avant suppression (méthode statique) ───────────
    public static function archiver(string $type, $objet): string
    {
        $xml  = new SimpleXMLElement('<archive/>');
        $xml->addChild('type', $type);
        $xml->addChild('date_suppression', now()->toISOString());
        $xml->addChild('supprime_par', auth()->user()->name ?? 'Système');

        $enregs = $xml->addChild('enregistrements');
        $enreg  = $enregs->addChild('enregistrement');

        foreach ($objet->toArray() as $key => $value) {
            if (!is_array($value)) {
                $enreg->addChild($key, is_null($value) ? 'NULL' : htmlspecialchars((string) $value));
            }
        }

        // Relations lignes
        if (method_exists($objet, 'lignes') && $objet->relationLoaded('lignes')) {
            $lignesNode = $xml->addChild('lignes');
            foreach ($objet->lignes as $ligne) {
                $ligneNode = $lignesNode->addChild('ligne');
                foreach ($ligne->toArray() as $key => $value) {
                    if (!is_array($value)) {
                        $ligneNode->addChild($key, is_null($value) ? 'NULL' : htmlspecialchars((string) $value));
                    }
                }
            }
        }

        $nom = $type . '_' . $objet->id . '_' . now()->format('Ymd_His') . '.xml';
        Storage::put('archives/' . $nom, $xml->asXML());

        return $nom;
    }

    // ─── Map type → Modèle ────────────────────────────────────────
    private function getModele(string $type): ?string
    {
        $map = [
            'produit'                  => \App\Models\Produit::class,
            'famille_produit'          => \App\Models\FamilleProduit::class,
            'fournisseur'              => \App\Models\Fournisseur::class,
            'client'                   => \App\Models\Client::class,
            'categorie_client'         => \App\Models\CategorieClient::class,
            'banque'                   => \App\Models\Banque::class,
            'bon_commande_fournisseur' => \App\Models\BonCommandeFournisseur::class,
            'facture_fournisseur'      => \App\Models\FactureFournisseur::class,
            'bon_entree'               => \App\Models\BonEntree::class,
            'commande_client'          => \App\Models\CommandeClient::class,
            'facture_client'           => \App\Models\FactureClient::class,
            'bon_sortie'               => \App\Models\BonSortie::class,
        ];

        return $map[$type] ?? null;
    }
}