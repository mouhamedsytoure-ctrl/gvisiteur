<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Liste des clients + formulaire inline.
     */
    public function index()
    {
        // On récupère tous les clients pour l’historique
        $clients = Client::orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Formulaire de création (optionnel si tu utilises tout en inline).
     * Tu peux même ne pas l’utiliser et toujours passer par index().
     */
    public function create()
    {
        return redirect()->route('clients.index');
    }

    /**
     * Enregistrement d’un client (soumission du formulaire à gauche).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'telephone'  => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'entreprise' => 'nullable|string|max:255',
            'adresse'    => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client enregistré avec succès.');
    }

    /**
     * Détail d’un client (si tu veux une page dédiée).
     * Avec ton système de détails inline, ce n’est pas obligatoire.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Formulaire d’édition d’un client.
     * Tu peux soit utiliser une page séparée, soit faire un modal plus tard.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Mise à jour d’un client.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'telephone'  => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'entreprise' => 'nullable|string|max:255',
            'adresse'    => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Suppression d’un client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}
