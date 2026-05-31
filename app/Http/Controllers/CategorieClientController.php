<?php

namespace App\Http\Controllers;

use App\Models\CategorieClient;
use Illuminate\Http\Request;

class CategorieClientController extends Controller
{
    public function index()
    {
        $categories = CategorieClient::withCount('clients')->latest()->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:255',
            'remise_default' => 'required|numeric|min:0|max:100',
        ]);

        CategorieClient::create($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(CategorieClient $category)
    {
        $clients = $category->clients()->paginate(15);
        return view('categories.show', compact('category', 'clients'));
    }

    public function edit(CategorieClient $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, CategorieClient $category)
    {
        $request->validate([
            'nom'            => 'required|string|max:255',
            'remise_default' => 'required|numeric|min:0|max:100',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(CategorieClient $category)
    {
        ArchiveController::archiver('categorie_client', $category);
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée et archivée en XML.');
    }
}
