<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CategorieClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('categorie')->latest()->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $categories = CategorieClient::all();
        return view('clients.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories_clients,id',
            'nom'          => 'required|string|max:255',
            'telephone'    => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'adresse'      => 'nullable|string',
        ]);

        Client::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    public function show(Client $client)
    {
        $client->load('commandes', 'factures');
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $categories = CategorieClient::all();
        return view('clients.edit', compact('client', 'categories'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories_clients,id',
            'nom'          => 'required|string|max:255',
            'telephone'    => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'adresse'      => 'nullable|string',
        ]);

        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Client modifié avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
