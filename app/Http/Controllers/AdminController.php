<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visite;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Historique des visites enregistrées par les secrétaires.
     * Accessible uniquement au rôle admin.
     */
    public function historiqueSecretaires()
    {
        // Vérification que l'utilisateur est admin
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Accès réservé à l’administrateur.');
        }

        // Tous les secrétaires
        $secretaires = User::where('role', 'secretaire')->get();

        // Toutes les visites enregistrées par des secrétaires
        $visites = Visite::with(['client', 'user'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'secretaire');
            })
            ->orderBy('date_arrivee', 'desc')
            ->get();

        return view('admin.historique_secretaires', compact('secretaires', 'visites'));
    }
}
