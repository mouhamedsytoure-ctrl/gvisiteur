@extends('layouts.app')

@section('title', 'Historique des secrétaires')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0" style="font-size:1.6rem; font-weight:800; color:#111827;">
                Historique des secrétaires
            </h2>
            <p class="text-muted mb-0 small">
                Suivi des visites enregistrées par les secrétaires.
            </p>
        </div>

        @if(!$visites->isEmpty())
            <div class="text-end small text-muted">
                Total : <strong>{{ $visites->count() }}</strong> visite(s)
            </div>
        @endif
    </div>

    @if ($visites->isEmpty())
        <div class="card card-dark p-3">
            <p class="mb-0 text-muted">
                Aucune visite enregistrée par un secrétaire pour le moment.
            </p>
        </div>
    @else
        <div class="card card-dark p-3">

            {{-- BARRE DE RECHERCHE / FILTRE --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="min-width:260px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input id="search-secretaires"
                               type="text"
                               class="form-control border-start-0"
                               placeholder="Rechercher par secrétaire, client, motif...">
                    </div>
                </div>

                <div class="small text-muted">
                    <span class="badge-soft badge-soft-warning me-1">En cours</span>
                    <span class="badge-soft badge-soft-success me-1">Terminée</span>
                </div>
            </div>

            {{-- TABLEAU --}}
            <div class="table-responsive">
                <table class="table table-borderless table-sm align-middle mb-0">
                    <thead>
                        <tr class="small-muted">
                            <th>#</th>
                            <th>Secrétaire</th>
                            <th>Client</th>
                            <th>Date d’arrivée</th>
                            <th>Date de sortie</th>
                            <th>Motif</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody id="secretaires-table">
                        @foreach ($visites as $visite)
                            <tr>
                                <td class="small text-muted">{{ $visite->id }}</td>

                                <td>
                                    @if($visite->user)
                                        <div class="fw-semibold">
                                            {{ $visite->user->nom }} {{ $visite->user->prenom }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ $visite->user->email ?? '' }}
                                        </div>
                                    @else
                                        <span class="small text-muted">Non renseigné</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ optional($visite->client)->nom }} {{ optional($visite->client)->prenom }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ optional($visite->client)->entreprise ?? '—' }}
                                    </div>
                                </td>

                                <td class="small">
                                    {{ optional($visite->date_arrivee)->format('d/m/Y H:i') ?? '—' }}
                                </td>

                                <td class="small">
                                    {{ optional($visite->date_sortie)->format('d/m/Y H:i') ?? '—' }}
                                </td>

                                <td class="small">
                                    {{ \Illuminate\Support\Str::limit($visite->motif ?? '-', 60) }}
                                </td>

                                <td>
                                    @php $s = strtoupper($visite->statut ?? '') @endphp

                                    @if($s === 'EN_COURS')
                                        <span class="badge-soft badge-soft-warning">En cours</span>
                                    @elseif($s === 'TERMINEE')
                                        <span class="badge-soft badge-soft-success">Terminée</span>
                                    @else
                                        <span class="badge-soft badge-soft-secondary">{{ $s ?: 'N/A' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @endif
</div>

{{-- Filtre simple côté client --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('search-secretaires');
    const rows   = Array.from(document.querySelectorAll('#secretaires-table tr'));

    if (search) {
        search.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
