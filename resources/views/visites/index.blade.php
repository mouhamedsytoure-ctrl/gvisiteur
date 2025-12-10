@extends('layouts.app')

@section('title', 'Visites – Gestion')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0" style="font-size:1.6rem; font-weight:800; color:#111827;">
                Enregistrement & Historique des Visites
            </h2>
            <p class="text-muted mb-0 small">Ajouter une visite et consulter les historiques.</p>
        </div>

        <div>
            <a href="{{ route('visites.create') }}" class="btn btn-accent">+ Nouvelle visite</a>
        </div>
    </div>

    <div class="row g-4">

        {{-- ====================== FORMULAIRE COMPLET À GAUCHE ======================= --}}
        <div class="col-12 col-lg-4">
            <div class="card card-dark p-3">

                <h6 class="mb-2" style="font-weight:600">Ajouter une nouvelle visite</h6>
                <p class="small-muted mb-3">Formulaire complet</p>

                <form action="{{ route('visites.store') }}" method="POST" autocomplete="off">
                    @csrf

                    {{-- CLIENT VISITÉ --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Client visité</label>
                        <select name="client_id" class="form-control" required>
                            <option value="">Sélectionner un client…</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->nom }} {{ $client->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NOM VISITEUR --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Nom du visiteur</label>
                        <input name="nom_visiteur" class="form-control" placeholder="Nom complet" required>
                    </div>

                    {{-- PERSONNE RENCONTRÉE --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Personne rencontrée</label>
                        <input name="personne_rencontree" class="form-control" placeholder="Ex : Directeur" required>
                    </div>

                    {{-- MOTIF --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Motif</label>
                        <textarea name="motif" rows="2" class="form-control"
                                  placeholder="Motif de la visite"></textarea>
                    </div>

                    {{-- DATES --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Date & heure d'arrivée</label>
                        <input type="datetime-local" name="date_arrivee" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold">Date & heure de sortie</label>
                        <input type="datetime-local" name="date_sortie" class="form-control">
                    </div>

                    {{-- STATUT --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Statut</label>
                        <select name="statut" class="form-control">
                            <option value="EN_COURS">En cours</option>
                            <option value="TERMINEE">Terminée</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-accent" type="submit">Enregistrer la visite</button>
                        <a href="{{ route('visites.index') }}" class="btn btn-outline-light">Annuler</a>
                    </div>
                </form>

            </div>
        </div>

        {{-- ====================== LISTE DES VISITES (DROITE) ======================= --}}
        <div class="col-12 col-lg-8">
            <div class="card card-dark p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0" style="font-weight:600">Historique des visites</h6>
                        <p class="small-muted mb-0">
                            Cliquer sur une ligne pour voir le détail (client visité, heures, motif).
                        </p>
                    </div>

                    <div class="d-flex gap-2 align-items-center">
                        <input id="search" type="text" class="form-control form-control-sm"
                               placeholder="Rechercher une visite…" style="min-width:220px">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-sm align-middle mb-0">
                        <thead>
                            <tr class="small-muted">
                                <th>Visiteur</th>
                                <th>Statut</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody id="visits-table">
                            @forelse($visites as $visite)
                                {{-- LIGNE PRINCIPALE (RÉSUMÉ) --}}
                                <tr onclick="toggleDetails({{ $visite->id }})"
                                    style="cursor:pointer;">
                                    {{-- VISITEUR (nom_visiteur) --}}
                                    <td>
                                        <span class="fw-medium">
                                            {{ $visite->nom_visiteur }}
                                        </span>
                                    </td>

                                    {{-- STATUT --}}
                                    <td>
                                        @php $s = strtoupper($visite->statut ?? '') @endphp

                                        @if($s === 'TERMINEE')
                                            <span class="badge-soft badge-soft-success">Terminée</span>
                                        @elseif($s === 'EN_COURS')
                                            <span class="badge-soft badge-soft-warning">En cours</span>
                                        @else
                                            <span class="badge-soft badge-soft-secondary">N/A</span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('visites.edit', $visite->id) }}"
                                               class="btn btn-sm btn-outline-dark">
                                                Éditer
                                            </a>

                                            <form action="{{ route('visites.destroy', $visite->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirmDelete(event, this)"
                                                  class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- LIGNE DÉTAILS : VISITEUR + CLIENT VISITÉ + HEURES + MOTIF --}}
                                <tr id="details-{{ $visite->id }}" class="details-row" style="display:none;">
                                    <td colspan="3" class="bg-light p-3 small">

                                        <div class="mb-1">
                                            <strong>Visiteur :</strong>
                                            {{ $visite->nom_visiteur }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Client visité :</strong>
                                            {{ optional($visite->client)->nom }}
                                            {{ optional($visite->client)->prenom }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Arrivée :</strong>
                                            @if($visite->date_arrivee)
                                                {{ \Carbon\Carbon::parse($visite->date_arrivee)->format('d/m/Y H:i') }}
                                            @endif
                                        </div>

                                        <div class="mb-1">
                                            <strong>Sortie :</strong>
                                            @if($visite->date_sortie)
                                                {{ \Carbon\Carbon::parse($visite->date_sortie)->format('d/m/Y H:i') }}
                                            @endif
                                        </div>

                                        <div class="mb-1">
                                            <strong>Motif :</strong>
                                            {{ $visite->motif }}
                                        </div>

                                        <div class="mt-1 text-muted">
                                            <em>Cliquer à nouveau sur la ligne pour masquer.</em>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="3" class="text-center small-muted py-4">
                                        Aucune visite enregistrée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    // Affichage / masquage des détails
    function toggleDetails(id) {
        const row = document.getElementById('details-' + id);
        if (!row) return;
        row.style.display = (row.style.display === 'none' || row.style.display === '')
            ? 'table-row'
            : 'none';
    }

    // Recherche côté client (sur les lignes principales)
    document.addEventListener('DOMContentLoaded', function () {
        const search   = document.getElementById('search');
        const mainRows = Array.from(document.querySelectorAll('#visits-table tr'))
            .filter(r => !r.classList.contains('details-row'));

        search?.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();

            mainRows.forEach(r => {
                const text    = r.innerText.toLowerCase();
                const idMatch = r.getAttribute('onclick')?.match(/\d+/);
                const id      = idMatch ? idMatch[0] : null;
                const detailsRow = id ? document.getElementById('details-' + id) : null;

                const match = text.includes(q);
                r.style.display = match ? '' : 'none';

                if (detailsRow && !match) {
                    detailsRow.style.display = 'none';
                }
            });
        });
    });

    // Confirmation suppression
    function confirmDelete(ev, form) {
        ev.preventDefault();
        if (confirm('Confirmer la suppression de cette visite ?')) {
            form.submit();
        }
        return false;
    }
</script>

@endsection
