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
        $visites = Visite::with('client')->orderBy('id', 'desc')->get();
        return view('visites.index', compact('visites'));
    }

    /**
     * Formulaire d'ajout d'une visite.
     */
    public function create()
    {
        $clients = Client::orderBy('nom')->get();
        return view('visites.create', compact('clients'));
    }

    /**
     * Enregistrement d'une visite.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'          => 'required|exists:clients,id',
            'date_arrivee'       => 'required|date',
            'motif'              => 'required|string',
            'personne_rencontree'=> 'required|string|max:255',
            'date_sortie'        => 'nullable|date',
            'statut'             => 'nullable|in:EN_COURS,TERMINEE',
        ]);

        Visite::create($request->all());

        return redirect()->route('visites.index')->with('success', 'Visite enregistrée.');
    }

    public function show(Visite $visite)
    {
        return view('visites.show', compact('visite'));
    }

    /**
     * Formulaire de modification.
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
            'client_id'          => 'required|exists:clients,id',
            'date_arrivee'       => 'required|date',
            'motif'              => 'required|string',
            'personne_rencontree'=> 'required|string|max:255',
            'date_sortie'        => 'nullable|date',
            'statut'             => 'required|in:EN_COURS,TERMINEE',
        ]);

        $visite->update($request->all());

        return redirect()->route('visites.index')->with('success', 'Visite mise à jour.');
    }

    /**
     * Suppression d'une visite.
     */
    public function destroy(Visite $visite)
    {
        $visite->delete();
        return redirect()->route('visites.index')->with('success', 'Visite supprimée.');
    }
}
