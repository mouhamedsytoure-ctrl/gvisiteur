<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Liste des clients.
     */
    public function index()
    {
        $clients = Client::orderBy('nom')->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Formulaire d'ajout d'un client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistrement d’un nouveau client.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email'     => 'nullable|email',
            'entreprise'=> 'nullable|string|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Affichage d’un client (non utilisé mais on le laisse).
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Mise à jour du client.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email'     => 'nullable|email',
            'entreprise'=> 'nullable|string|max:255',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Suppression d’un client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé.');
    }
}
