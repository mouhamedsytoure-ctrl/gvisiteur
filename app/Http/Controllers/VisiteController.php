<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use App\Models\Client;
use Illuminate\Http\Request;

class VisiteController extends Controller
{
    /**
     * Liste des visites.
     */
    public function index()
    {
        $visites = Visite::with(['client', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        $clients = Client::orderBy('nom')->get();

        return view('visites.index', compact('visites', 'clients'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $clients = Client::orderBy('nom')->get();
        return view('visites.create', compact('clients'));
    }

    /**
     * Enregistrement d’une visite.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'nom_visiteur'        => 'required|string|max:255',
            'date_arrivee'        => 'required|date',
            'motif'               => 'required|string',
            'personne_rencontree' => 'required|string',
            'date_sortie'         => 'nullable|date',
            'statut'              => 'required|in:EN_COURS,TERMINEE',
        ]);

        $validated['user_id'] = auth()->id();

        Visite::create($validated);

        return redirect()
            ->route('visites.index')
            ->with('success', 'Visite enregistrée avec succès.');
    }

    /**
     * Détail d’une visite (si tu l’utilises).
     */
    public function show(Visite $visite)
    {
        return view('visites.show', compact('visite'));
    }

    /**
     * Formulaire d’édition.
     */
    public function edit(Visite $visite)
    {
        $clients = Client::orderBy('nom')->get();
        return view('visites.edit', compact('visite', 'clients'));
    }

    /**
     * Mise à jour d'une visite.
     */
    public function update(Request $request, Visite $visite)
    {
        $validated = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'nom_visiteur'        => 'required|string|max:255',
            'date_arrivee'        => 'required|date',
            'motif'               => 'required|string',
            'personne_rencontree' => 'required|string',
            'date_sortie'         => 'nullable|date',
            'statut'              => 'required|in:EN_COURS,TERMINEE',
        ]);

        $visite->update($validated);

        return redirect()
            ->route('visites.index')
            ->with('success', 'Visite mise à jour avec succès.');
    }

    /**
     * Suppression.
     */
    public function destroy(Visite $visite)
    {
        $visite->delete();

        return redirect()
            ->route('visites.index')
            ->with('success', 'Visite supprimée.');
    }
}
