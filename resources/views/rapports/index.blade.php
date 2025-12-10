@extends('layouts.app')

@section('title', 'Rapports – GVisiteur')

@section('content')
<div class="container-fluid py-3">

    <h2 class="mb-1">Rapports</h2>
    <p class="text-muted mb-4">Analyse rapide des visites & impression.</p>

    {{-- ====================== FILTRE ====================== --}}
    <div class="card card-dark p-3 mb-4">

        <h5 class="mb-3">Filtrer les visites</h5>

        <form method="GET" class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Date de début</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Date de fin</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-accent w-100">Filtrer</button>
            </div>

        </form>
    </div>

    {{-- ====================== BOUTONS ====================== --}}
    <div class="d-flex justify-content-end gap-3 mb-3">
        <button onclick="window.print()" class="btn btn-accent">
            🖨️ Imprimer le rapport
        </button>
    </div>

    {{-- ====================== TABLEAU ====================== --}}
    <div class="card card-dark p-3">

        <h5 class="mb-3">Historique des visites filtrées</h5>

        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Visiteur</th>
                        <th>Client visité</th>
                        <th>Arrivée</th>
                        <th>Sortie</th>
                        <th>Motif</th>
                        <th>Statut</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($visites as $v)
                        <tr>
                            <td>{{ $v->nom_visiteur }}</td>
                            <td>
                                {{ optional($v->client)->nom }}
                                {{ optional($v->client)->prenom }}
                            </td>
                            <td>{{ $v->date_arrivee }}</td>
                            <td>{{ $v->date_sortie }}</td>
                            <td>{{ $v->motif }}</td>
                            <td>{{ $v->statut }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucune visite trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- STYLE IMPRESSION --}}
<style>
@media print {

    nav, .sidebar, .btn, form, .btn-accent, .navbar, .menu-title {
        display: none !important;
    }

    body {
        margin: 0;
        padding: 0;
        background: white !important;
    }

    .content {
        margin: 0 !important;
        padding: 0 !important;
    }

    table {
        border: 1px solid #000;
    }
}
</style>

@endsection
