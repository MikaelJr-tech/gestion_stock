<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use Illuminate\Http\Request;

class BanqueController extends Controller
{
    public function index()
    {
        $banques = Banque::withCount('versements')->latest()->paginate(15);
        return view('banques.index', compact('banques'));
    }

    public function create()
    {
        return view('banques.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'           => 'required|string|max:255',
            'numero_compte' => 'nullable|string|max:100',
            'solde'         => 'required|numeric|min:0',
        ]);

        Banque::create($request->all());
        return redirect()->route('banques.index')
            ->with('success', 'Banque créée avec succès.');
    }

    public function show(Banque $banque)
    {
        $versements = $banque->versements()->latest()->paginate(15);
        return view('banques.show', compact('banque', 'versements'));
    }

    public function edit(Banque $banque)
    {
        return view('banques.edit', compact('banque'));
    }

    public function update(Request $request, Banque $banque)
    {
        $request->validate([
            'nom'           => 'required|string|max:255',
            'numero_compte' => 'nullable|string|max:100',
        ]);

        $banque->update($request->all());
        return redirect()->route('banques.index')
            ->with('success', 'Banque modifiée avec succès.');
    }

    public function destroy(Banque $banque)
    {
        ArchiveController::archiver('banque', $banque);
        $banque->delete();
        return redirect()->route('banques.index')
            ->with('success', 'Banque supprimée et archivée en XML.');
    }
}
