<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tableau de bord dynamique.
     */
    public function index()
    {
        Carbon::setLocale('fr');

        // Références de temps
        $today       = Carbon::today();
        $startWeek   = Carbon::now()->startOfWeek();   // lundi
        $endWeek     = Carbon::now()->endOfWeek();     // dimanche
        $startMonth6 = Carbon::now()->subMonths(5)->startOfMonth(); // il y a 6 mois
        $endMonth6   = Carbon::now()->endOfMonth();    // fin du mois courant

        // Stats globales
        $totalVisites       = Visite::count();
        $visitesEnCours     = Visite::where('statut', 'EN_COURS')->count();
        $visitesTerminees   = Visite::where('statut', 'TERMINEE')->count();

        // Visites du jour
        $visitesJour = Visite::whereDate('date_arrivee', $today)->count();

        // Visites de la semaine (lundi → dimanche)
        $visitesSemaine = Visite::whereBetween('date_arrivee', [
            $startWeek->copy()->startOfDay(),
            $endWeek->copy()->endOfDay(),
        ])->count();

        // Taux de conversion : visites terminées / total
        $tauxConversion = $totalVisites > 0
            ? round(($visitesTerminees / $totalVisites) * 100)
            : 0;

        // --- Visites par jour de la semaine (graphique barres) ---
        $semaine = [];
        $cursor = $startWeek->copy();
        for ($i = 0; $i < 7; $i++) {
            $semaine[] = [
                'label' => ucfirst($cursor->locale('fr_FR')->isoFormat('dd')), // lu, ma, me...
                'total' => Visite::whereDate('date_arrivee', $cursor->toDateString())->count(),
            ];
            $cursor->addDay();
        }

        $labelsSemaine = array_column($semaine, 'label');
        $dataSemaine   = array_column($semaine, 'total');

        // --- Visites par mois sur les 6 derniers mois (graphique courbe) ---
        $raw = Visite::selectRaw('DATE_FORMAT(date_arrivee, "%Y-%m") as ym, COUNT(*) as total')
            ->whereBetween('date_arrivee', [$startMonth6, $endMonth6])
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $labelsMois = [];
        $dataMois   = [];

        $cursorMonth = $startMonth6->copy();
        while ($cursorMonth <= $endMonth6) {
            $key = $cursorMonth->format('Y-m');
            $labelsMois[] = ucfirst($cursorMonth->locale('fr_FR')->isoFormat('MMM YYYY')); // ex : déc. 2025
            $dataMois[]   = $raw[$key] ?? 0;
            $cursorMonth->addMonthNoOverflow()->startOfMonth();
        }

        // --- Dernières visites pour le tableau du bas ---
        $dernieresVisites = Visite::with('client')
            ->orderByDesc('date_arrivee') // ou created_at si tu préfères
            ->take(10)
            ->get();

        return view('dashboard', [
            'totalVisites'      => $totalVisites,
            'visitesEnCours'    => $visitesEnCours,
            'visitesTerminees'  => $visitesTerminees,
            'visitesJour'       => $visitesJour,
            'visitesSemaine'    => $visitesSemaine,
            'tauxConversion'    => $tauxConversion,
            'labelsSemaine'     => $labelsSemaine,
            'dataSemaine'       => $dataSemaine,
            'labelsMois'        => $labelsMois,
            'dataMois'          => $dataMois,
            'dernieresVisites'  => $dernieresVisites,
        ]);
    }
}
