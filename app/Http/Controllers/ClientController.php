<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients.
     */
    public function index()
    {
        $clients = Client::orderBy('nom')->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistrer un nouveau client.
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

        Client::create($request->only(['nom', 'prenom', 'telephone', 'email', 'entreprise']));

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Afficher un client (facultatif).
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Afficher le formulaire d’édition.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Mettre à jour un client.
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

        $client->update($request->only(['nom', 'prenom', 'telephone', 'email', 'entreprise']));

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprimer un client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}
