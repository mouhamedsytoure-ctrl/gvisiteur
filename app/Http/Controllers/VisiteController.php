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
        // Récupération des visites avec leurs relations
        $visites = Visite::with(['client', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        // Récupération de tous les clients pour le select du formulaire
        $clients = Client::orderBy('nom')->get();

        // On envoie les deux variables à la vue
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
        $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'date_arrivee'        => 'required|date',
            'motif'               => 'required|string',
            'personne_rencontree' => 'required|string',
            'date_sortie'         => 'nullable|date',
            'statut'              => 'required|in:EN_COURS,TERMINEE',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id(); // Qui a enregistré cette visite

        Visite::create($data);

        return redirect()
            ->route('visites.index')
            ->with('success', 'Visite enregistrée avec succès.');
    }

    /**
     * Détail d’une visite (optionnel).
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
        $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'date_arrivee'        => 'required|date',
            'motif'               => 'required|string',
            'personne_rencontree' => 'required|string',
            'date_sortie'         => 'nullable|date',
            'statut'              => 'required|in:EN_COURS,TERMINEE',
        ]);

        $data = $request->all();
        $visite->update($data);

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
