@extends('layouts.app')

@section('title', 'Clients – Gestion des visites')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0" style="font-size:1.6rem; font-weight:800; color:#111827;">
                Gestion des Clients
            </h2>
            <p class="text-muted mb-0 small">Liste et gestion des clients enregistrés</p>
        </div>

        <div>
            <a href="{{ route('clients.create') }}" class="btn btn-accent">
                + Nouveau client
            </a>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success py-2 small">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">

        {{-- LISTE DES CLIENTS --}}
        <div class="col-12">
            <div class="card card-dark p-3">

                {{-- Header de la liste --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0" style="font-weight:600">Liste des Clients</h6>
                        <p class="small-muted mb-0">Clients enregistrés dans le système</p>
                    </div>

                    <div class="d-flex gap-2 align-items-center">
                        <input id="search-clients" type="text"
                               class="form-control form-control-sm"
                               placeholder="Rechercher un client..."
                               style="min-width:220px">
                    </div>
                </div>

                @if ($clients->isEmpty())
                    <p class="mb-0 text-muted small">Aucun client pour le moment. Ajoutez un premier client.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm align-middle mb-0">
                            <thead>
                                <tr class="small-muted">
                                    <th>#</th>
                                    <th>Nom complet</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Entreprise</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="clients-table">
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>

                                        <td>
                                            {{-- Nom cliquable pour éditer, comme pour les visites --}}
                                            <a href="{{ route('clients.edit', $client) }}"
                                               class="text-decoration-none fw-medium">
                                                {{ $client->nom }} {{ $client->prenom }}
                                            </a>
                                        </td>

                                        <td>{{ $client->telephone }}</td>
                                        <td>{{ $client->email ?? '—' }}</td>
                                        <td>{{ $client->entreprise ?? '—' }}</td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <a href="{{ route('clients.edit', $client) }}"
                                                   class="btn btn-sm btn-outline-dark">
                                                    Modifier
                                                </a>

                                                <form action="{{ route('clients.destroy', $client) }}"
                                                      method="POST"
                                                      onsubmit="return confirmDeleteClient(event, this)"
                                                      class="m-0 d-inline">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
  // Recherche simple côté client (filtre texte) — même logique que visites
  document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('search-clients');
    const rows = Array.from(document.querySelectorAll('#clients-table tr'));

    if (search) {
      search.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        rows.forEach(r => {
          const text = r.innerText.toLowerCase();
          r.style.display = text.includes(q) ? '' : 'none';
        });
      });
    }
  });

  // Confirmation avant suppression (spécifique clients)
  function confirmDeleteClient(ev, form) {
    ev.preventDefault();
    if (confirm('Confirmer la suppression de ce client ?')) {
      form.submit();
    }
    return false;
  }
</script>
@endsection
