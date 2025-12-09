@extends('layouts.app')

@section('title', 'Tableau de bord – Gestion des visites')

@section('content')
<div class="container-fluid dashboard-wrapper">

    <style>
        /* Wrapper global du dashboard */
        .dashboard-wrapper {
            background: #f6f6f8;
            padding-top: 16px;
            padding-bottom: 24px;
        }

        /* Style "carte blanche moderne" */
        .card-dark {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        /* Header */
        .dashboard-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #111827;
        }
        .dashboard-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* KPI cards */
        .kpi-card {
            padding: 18px 16px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .kpi-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-right: 4px;
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.14), rgba(218, 165, 32, 0.04));
        }
        .kpi-title {
            font-size: 13px;
            color: #6b7280;
        }
        .kpi-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1.1;
        }
        .kpi-note {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Carte des filtres */
        .controls-card {
            border-radius: 16px;
            padding: 12px 18px;
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .controls-left {
            display: flex;
            gap: 12px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .controls-right {
            color: #6b7280;
            font-size: 13px;
        }

        .small-muted {
            color: #6b7280;
            font-size: 13px;
        }

        /* Cartes graphiques */
        .chart-card {
            padding: 18px 18px 16px 18px;
            border-radius: 16px;
        }

        /* Progress bar conversion */
        .progress {
            background-color: #e5e7eb;
        }

        /* Badges / puces statut */
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            display: inline-block;
            margin-right: 6px;
        }
        .status-dot-success { background-color: #10b981; }
        .status-dot-warning { background-color: #f59e0b; }
        .status-dot-muted { background-color: #9ca3af; }

        .badge-soft {
            border-radius: 999px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-soft-success {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }
        .badge-soft-warning {
            background: rgba(245, 158, 11, 0.12);
            color: #92400e;
        }
        .badge-soft-secondary {
            background: rgba(31, 41, 55, 0.06);
            color: #374151;
        }

        /* Canvas Chart.js */
        canvas {
            display: block;
            width: 100% !important;
            height: 320px !important;
        }

        @media (max-width: 768px) {
            .kpi-value {
                font-size: 22px;
            }
            canvas {
                height: 260px !important;
            }
            .controls-card {
                align-items: flex-start;
            }
        }
    </style>

    <!-- Header -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-0 dashboard-title">Tableau de bord</h3>
            <p class="dashboard-subtitle mb-0">Suivi des visites et activité du secrétariat</p>
        </div>
        <div class="text-muted small">
            Dernière mise à jour :
            {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('LLL') }}
        </div>
    </div>

    <!-- Controls -->
    <div class="mb-4">
        <div class="card card-dark controls-card">
            <div class="controls-left">
                <div class="small-muted">Filtrer :</div>

                <div>
                    <label class="form-label small mb-1">Semaine</label>
                    <select id="filterSemaine" class="form-select form-select-sm">
                        <option value="all">Semaine courante (Tous)</option>
                        <option value="0">Lundi</option>
                        <option value="1">Mardi</option>
                        <option value="2">Mercredi</option>
                        <option value="3">Jeudi</option>
                        <option value="4">Vendredi</option>
                        <option value="5">Samedi</option>
                        <option value="6">Dimanche</option>
                    </select>
                </div>

                <div>
                    <label class="form-label small mb-1">Mois</label>
                    <select id="filterMois" class="form-select form-select-sm">
                        <option value="all">6 derniers mois (Tous)</option>
                        @foreach($labelsMois as $i => $label)
                            <option value="{{ $i }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="controls-right">
                Affichez la période souhaitée — les graphiques s'actualisent immédiatement.
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card card-dark kpi-card">
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 20v-8" stroke="#DAA520" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 20V10" stroke="#DAA520" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 20v-4" stroke="#DAA520" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <div class="kpi-title">Visites en cours</div>
                    <div class="kpi-value">{{ $visitesEnCours }}</div>
                    <div class="kpi-note">Statut <strong>EN_COURS</strong></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card card-dark kpi-card">
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M6 2v6" stroke="#1f9bd6" stroke-width="1.6" stroke-linecap="round"/>
                        <path d="M18 2v10" stroke="#1f9bd6" stroke-width="1.6" stroke-linecap="round"/>
                        <path d="M3 12h18" stroke="#1f9bd6" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="kpi-title">Visites du jour</div>
                    <div class="kpi-value">{{ $visitesJour }}</div>
                    <div class="kpi-note">Basé sur la date d'arrivée d'aujourd'hui</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card card-dark kpi-card">
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="8" stroke="#6f42c1" stroke-width="1.6"/>
                    </svg>
                </div>
                <div>
                    <div class="kpi-title">Visites de la semaine</div>
                    <div class="kpi-value">{{ $visitesSemaine }}</div>
                    <div class="kpi-note">Lundi → Dimanche</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card card-dark kpi-card">
                <div class="kpi-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M3 12h18" stroke="#10b981" stroke-width="1.6"/>
                    </svg>
                </div>
                <div style="flex:1">
                    <div class="kpi-title">Taux de conversion</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="kpi-value">{{ $tauxConversion }}%</div>
                        <div style="width:40%;">
                            <div class="progress" style="height:8px;border-radius:6px;">
                                <div class="progress-bar"
                                     role="progressbar"
                                     style="
                                        width: {{ $tauxConversion }}%;
                                        background:#DAA520;
                                        height:8px;
                                        border-radius:6px;
                                     ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-note">
                        {{ $visitesTerminees }} terminées / {{ $totalVisites }} totales
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOC : Actions rapides + Synthèse statuts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card card-dark p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0" style="font-weight:600;font-size:14px;color:#111827;">Actions rapides</h6>
                    <span class="small-muted">Gagnez du temps au quotidien</span>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <a href="{{ route('visites.create') }}" class="btn btn-sm btn-dark">
                        + Nouvelle visite
                    </a>
                    @if(Route::has('clients.create'))
                        <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-secondary">
                            + Nouveau client
                        </a>
                    @endif
                    @if(Route::has('visites.historique'))
                        <a href="{{ route('visites.historique') }}" class="btn btn-sm btn-outline-dark">
                            Historique avancé
                        </a>
                    @endif
                    @if(Route::has('visites.export'))
                        <a href="{{ route('visites.export') }}" class="btn btn-sm btn-outline-warning">
                            Exporter les visites
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card card-dark p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0" style="font-weight:600;font-size:14px;color:#111827;">Synthèse des statuts</h6>
                    <span class="small-muted">Vue rapide par statut</span>
                </div>

                @php
                    $autresVisites = max($totalVisites - $visitesTerminees - $visitesEnCours, 0);
                @endphp

                <div class="d-flex flex-wrap gap-3 mt-2">
                    <div>
                        <div class="small-muted mb-1">
                            <span class="status-dot status-dot-success"></span>
                            Terminées
                        </div>
                        <div class="badge-soft badge-soft-success">
                            {{ $visitesTerminees }} visites
                        </div>
                    </div>
                    <div>
                        <div class="small-muted mb-1">
                            <span class="status-dot status-dot-warning"></span>
                            En cours
                        </div>
                        <div class="badge-soft badge-soft-warning">
                            {{ $visitesEnCours }} visites
                        </div>
                    </div>
                    <div>
                        <div class="small-muted mb-1">
                            <span class="status-dot status-dot-muted"></span>
                            Autres statuts
                        </div>
                        <div class="badge-soft badge-soft-secondary">
                            {{ $autresVisites }} visites
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row g-3 mb-4">

        <!-- Grande courbe journalière -->
        <div class="col-12 col-lg-8">
            <div class="card card-dark chart-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="small-muted">Visites par jour</div>
                        <div class="fw-semibold">Semaine courante</div>
                    </div>
                    <div class="small-muted">
                        Valeur sélectionnée :
                        <strong id="infoJourValue">—</strong>
                    </div>
                </div>

                <canvas id="chartJour"></canvas>

                <div class="mt-2 d-flex justify-content-between">
                    <div class="small-muted">Courbe journalière — aperçu propre et clair</div>
                    <div class="small-muted">Unités : visites</div>
                </div>
            </div>
        </div>

        <!-- Petit graphique mensuel -->
        <div class="col-12 col-lg-4">
            <div class="card card-dark chart-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="small-muted">Visites par mois</div>
                        <div class="fw-semibold">6 derniers mois</div>
                    </div>
                    <div class="small-muted">
                        Valeur :
                        <strong id="infoMoisValue">—</strong>
                    </div>
                </div>

                <canvas id="chartMois"></canvas>

                <div class="mt-2 small-muted">Barres mensuelles — tendance</div>
            </div>
        </div>
    </div>

    {{-- Dernières visites --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card card-dark p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0" style="font-weight:600;font-size:14px;color:#111827;">
                        Dernières visites enregistrées
                    </h6>
                    <span class="small-muted">Aperçu des 5 à 10 dernières lignes</span>
                </div>

                @isset($dernieresVisites)
                    @if($dernieresVisites->isEmpty())
                        <p class="small-muted mb-0">Aucune visite récente.</p>
                    @else
                        <div class="table-responsive mt-2">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr class="small-muted">
                                        <th>Client</th>
                                        <th>Visiteur</th>
                                        <th>Date arrivée</th>
                                        <th>Objet</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dernieresVisites as $visite)
                                        <tr>
                                            <td>{{ optional($visite->client)->nom ?? '—' }}</td>
                                            <td>{{ $visite->nom_visiteur ?? '—' }}</td>
                                            <td>
                                                {{ optional($visite->date_arrivee)->format('d/m/Y H:i') ?? '—' }}
                                            </td>
                                            <td class="small">
                                                {{ \Illuminate\Support\Str::limit($visite->motif ?? '—', 40) }}
                                            </td>
                                            <td>
                                                @php
                                                    $statut = strtoupper($visite->statut ?? '');
                                                    $badgeClass = 'badge-soft-secondary';
                                                    if ($statut === 'TERMINEE' || $statut === 'TERMINE') {
                                                        $badgeClass = 'badge-soft-success';
                                                    } elseif ($statut === 'EN_COURS') {
                                                        $badgeClass = 'badge-soft-warning';
                                                    }
                                                @endphp
                                                <span class="badge-soft {{ $badgeClass }}">
                                                    {{ $statut ?: 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @else
                    <p class="small-muted mb-0">
                        (Optionnel) Tu peux alimenter ce tableau avec un
                        <code>$dernieresVisites = Visite::with('client')->latest()->take(10)->get();</code>
                        depuis le contrôleur.
                    </p>
                @endisset
            </div>
        </div>
    </div>

    <!-- Rappel synthétique -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card card-dark p-3">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="small-muted">
                        Total visites : <strong>{{ $totalVisites }}</strong>
                        — dont <strong>{{ $visitesTerminees }}</strong> terminées
                    </div>
                    <div class="small-muted">
                        Utilisez le menu pour gérer clients & visites
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labelsMois    = @json($labelsMois);
    const dataMois      = @json($dataMois);
    const labelsSemaine = @json($labelsSemaine);
    const dataSemaine   = @json($dataSemaine);

    const accent = '#DAA520';
    const textColor = '#6b7280';

    // Grand graphique : jour (ligne)
    const ctxJour = document.getElementById('chartJour').getContext('2d');
    const gradJour = ctxJour.createLinearGradient(0, 0, 0, 300);
    gradJour.addColorStop(0, 'rgba(218,165,32,0.12)');
    gradJour.addColorStop(1, 'rgba(218,165,32,0.02)');

    const jourChart = new Chart(ctxJour, {
        type: 'line',
        data: {
            labels: labelsSemaine,
            datasets: [{
                label: 'Visites',
                data: dataSemaine,
                borderColor: accent,
                borderWidth: 2.6,
                backgroundColor: gradJour,
                tension: 0.25,
                pointRadius: 0,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#111',
                    borderColor: '#eee',
                    borderWidth: 1
                }
            },
            scales: {
                x: { ticks: { color: textColor }, grid: { color: 'rgba(0,0,0,0.03)' } },
                y: { ticks: { color: textColor }, beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } }
            }
        }
    });

    // Petit graphique : mois (barres arrondies)
    const ctxMois = document.getElementById('chartMois').getContext('2d');
    const moisChart = new Chart(ctxMois, {
        type: 'bar',
        data: {
            labels: labelsMois,
            datasets: [{
                label: 'Visites',
                data: dataMois,
                backgroundColor: labelsMois.map(() => 'rgba(218,165,32,0.95)'),
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
            scales: {
                x: { ticks: { color: textColor }, grid: { display: false } },
                y: { ticks: { color: textColor }, beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } }
            }
        }
    });

    const filterSemaine = document.getElementById('filterSemaine');
    const filterMois = document.getElementById('filterMois');
    const infoJour = document.getElementById('infoJourValue');
    const infoMois = document.getElementById('infoMoisValue');

    function highlightJour(index) {
        if (index === 'all') {
            jourChart.data.datasets[0].pointRadius = 0;
            jourChart.data.datasets[0].pointBackgroundColor = 'rgba(0,0,0,0)';
            infoJour.textContent = 'Tous';
        } else {
            const idx = parseInt(index, 10);
            const pointColors = new Array(labelsSemaine.length).fill('rgba(0,0,0,0)');
            pointColors[idx] = accent;
            jourChart.data.datasets[0].pointBackgroundColor = pointColors;
            jourChart.data.datasets[0].pointRadius = 4;
            infoJour.textContent = `${labelsSemaine[idx]} : ${dataSemaine[idx]} visites`;
        }
        jourChart.update();
    }

    function highlightMois(index) {
        if (index === 'all') {
            moisChart.data.datasets[0].backgroundColor =
                labelsMois.map(() => 'rgba(218,165,32,0.95)');
            infoMois.textContent = 'Tous';
        } else {
            const idx = parseInt(index, 10);
            const colors = labelsMois.map(() => 'rgba(218,165,32,0.25)');
            colors[idx] = 'rgba(218,165,32,0.95)';
            moisChart.data.datasets[0].backgroundColor = colors;
            infoMois.textContent = `${labelsMois[idx]} : ${dataMois[idx]} visites`;
        }
        moisChart.update();
    }

    filterSemaine.addEventListener('change', function () {
        highlightJour(this.value);
    });
    filterMois.addEventListener('change', function () {
        highlightMois(this.value);
    });

    // Initial
    highlightJour('all');
    highlightMois('all');
});
</script>
@endsection
