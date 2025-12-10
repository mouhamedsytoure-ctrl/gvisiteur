@extends('layouts.app')

@section('title', 'Clients – Gestion')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0" style="font-size:1.6rem; font-weight:800; color:#111827;">
                Gestion des clients
            </h2>
            <p class="text-muted mb-0 small">
                Ajouter un client et consulter l’historique des clients enregistrés.
            </p>
        </div>

        <div>
            {{-- Si tu as une page create séparée, tu peux garder ce bouton --}}
            {{-- <a href="{{ route('clients.create') }}" class="btn btn-accent">+ Nouveau client</a> --}}
        </div>
    </div>

    <div class="row g-4">

        {{-- ====================== FORMULAIRE CLIENT (GAUCHE) ======================= --}}
        <div class="col-12 col-lg-4">
            <div class="card card-dark p-3">

                <h6 class="mb-2" style="font-weight:600">Ajouter un nouveau client</h6>
                <p class="small-muted mb-3">Formulaire rapide</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('clients.store') }}" method="POST" autocomplete="off">
                    @csrf

                    {{-- NOM --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>

                    {{-- PRENOM --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>

                    {{-- TELEPHONE --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    {{-- ENTREPRISE --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Entreprise</label>
                        <input type="text" name="entreprise" class="form-control">
                    </div>

                    {{-- ADRESSE --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Adresse</label>
                        <textarea name="adresse" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-accent" type="submit">Enregistrer le client</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-light">Annuler</a>
                    </div>
                </form>

            </div>
        </div>

        {{-- ====================== LISTE DES CLIENTS (DROITE) ======================= --}}
        <div class="col-12 col-lg-8">
            <div class="card card-dark p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0" style="font-weight:600">Liste des clients</h6>
                        <p class="small-muted mb-0">
                            Cliquer sur une ligne pour voir le détail complet du client.
                        </p>
                    </div>

                    <div class="d-flex gap-2 align-items-center">
                        <input id="search" type="text" class="form-control form-control-sm"
                               placeholder="Rechercher un client…" style="min-width:220px">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-sm align-middle mb-0">
                        <thead>
                            <tr class="small-muted">
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody id="clients-table">
                            @forelse($clients as $client)
                                {{-- LIGNE PRINCIPALE (RÉSUMÉ) --}}
                                <tr onclick="toggleClientDetails({{ $client->id }})"
                                    style="cursor:pointer;">
                                    {{-- NOM COMPLET --}}
                                    <td>
                                        <span class="fw-medium">
                                            {{ $client->nom }} {{ $client->prenom }}
                                        </span>
                                    </td>

                                    {{-- TELEPHONE --}}
                                    <td>
                                        {{ $client->telephone ?? '-' }}
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('clients.edit', $client->id) }}"
                                               class="btn btn-sm btn-outline-dark">
                                                Éditer
                                            </a>

                                            <form action="{{ route('clients.destroy', $client->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirmDeleteClient(event, this)"
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

                                {{-- LIGNE DÉTAILS CLIENT --}}
                                <tr id="client-details-{{ $client->id }}" class="details-row" style="display:none;">
                                    <td colspan="3" class="bg-light p-3 small">

                                        <div class="mb-1">
                                            <strong>Nom complet :</strong>
                                            {{ $client->nom }} {{ $client->prenom }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Téléphone :</strong>
                                            {{ $client->telephone ?? '-' }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Email :</strong>
                                            {{ $client->email ?? '-' }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Entreprise :</strong>
                                            {{ $client->entreprise ?? '-' }}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Adresse :</strong>
                                            {{ $client->adresse ?? '-' }}
                                        </div>

                                        <div class="mb-1 text-muted">
                                            <strong>Créé le :</strong>
                                            @if($client->created_at)
                                                {{ $client->created_at->format('d/m/Y H:i') }}
                                            @endif
                                        </div>

                                        <div class="mt-1 text-muted">
                                            <em>Cliquer à nouveau sur la ligne pour masquer.</em>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="3" class="text-center small-muted py-4">
                                        Aucun client enregistré.
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
    // Affichage / masquage des détails client
    function toggleClientDetails(id) {
        const row = document.getElementById('client-details-' + id);
        if (!row) return;
        row.style.display = (row.style.display === 'none' || row.style.display === '')
            ? 'table-row'
            : 'none';
    }

    // Recherche côté client (sur les lignes principales)
    document.addEventListener('DOMContentLoaded', function () {
        const search   = document.getElementById('search');
        const mainRows = Array.from(document.querySelectorAll('#clients-table tr'))
            .filter(r => !r.classList.contains('details-row'));

        search?.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();

            mainRows.forEach(r => {
                const text    = r.innerText.toLowerCase();
                const idMatch = r.getAttribute('onclick')?.match(/\d+/);
                const id      = idMatch ? idMatch[0] : null;
                const detailsRow = id ? document.getElementById('client-details-' + id) : null;

                const match = text.includes(q);
                r.style.display = match ? '' : 'none';

                if (detailsRow && !match) {
                    detailsRow.style.display = 'none';
                }
            });
        });
    });

    // Confirmation suppression client
    function confirmDeleteClient(ev, form) {
        ev.preventDefault();
        if (confirm('Confirmer la suppression de ce client ?')) {
            form.submit();
        }
        return false;
    }
</script>

@endsection
