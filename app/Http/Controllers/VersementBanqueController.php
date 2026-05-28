<?php

namespace App\Http\Controllers;

use App\Models\VersementBanque;
use App\Models\Banque;
use Illuminate\Http\Request;

class VersementBanqueController extends Controller
{
    public function index()
    {
        $versements = VersementBanque::with('banque')->latest()->paginate(15);
        return view('versements.index', compact('versements'));
    }

    public function create()
    {
        $banques = Banque::all();
        return view('versements.create', compact('banques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'banque_id'       => 'required|exists:banques,id',
            'montant'         => 'required|numeric|min:0',
            'date_versement'  => 'required|date',
            'reference'       => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ]);

        $versement = VersementBanque::create($request->all());

        // Mettre à jour le solde de la banque
        $versement->banque->increment('solde', $versement->montant);

        return redirect()->route('versements.index')->with('success', 'Versement enregistré avec succès.');
    }

    public function show(VersementBanque $versement)
    {
        return view('versements.show', compact('versement'));
    }

    public function edit(VersementBanque $versement)
    {
        $banques = Banque::all();
        return view('versements.edit', compact('versement', 'banques'));
    }

    public function update(Request $request, VersementBanque $versement)
    {
        $request->validate([
            'banque_id'      => 'required|exists:banques,id',
            'montant'        => 'required|numeric|min:0',
            'date_versement' => 'required|date',
            'reference'      => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        // Recalculer le solde
        $versement->banque->decrement('solde', $versement->montant);
        $versement->update($request->all());
        $versement->banque->increment('solde', $request->montant);

        return redirect()->route('versements.index')->with('success', 'Versement modifié avec succès.');
    }

    public function destroy(VersementBanque $versement)
    {
        $versement->banque->decrement('solde', $versement->montant);
        $versement->delete();
        return redirect()->route('versements.index')->with('success', 'Versement supprimé avec succès.');
    }
}
