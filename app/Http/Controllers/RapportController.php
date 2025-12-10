<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visite;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $query = Visite::with('client')
            ->orderBy('date_arrivee', 'desc');

        if ($request->filled('from')) {
            $query->whereDate('date_arrivee', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date_arrivee', '<=', $request->to);
        }

        $visites = $query->get();

        return view('rapports.index', compact('visites', 'request'));
    }
}
