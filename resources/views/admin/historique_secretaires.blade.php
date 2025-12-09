@extends('layouts.app')

@section('title', 'Historique des secrétaires')

@section('content')
<div class="container-fluid">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1">Historique des secrétaires</h3>
            <p class="text-muted mb-0">
                Liste des visites enregistrées par les secrétaires.
            </p>
        </div>
    </div>

    @if ($visites->isEmpty())
        <div class="card card-dark p-3">
            <p class="mb-0 text-muted">Aucune visite enregistrée par un secrétaire pour le moment.</p>
        </div>
    @else
        <div class="card card-dark p-0 mb-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Secrétaire</th>
                            <th>Client</th>
                            <th>Date arrivée</th>
                            <th>Date sortie</th>
                            <th>Motif</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visites as $visite)
                            <tr>
                                <td>{{ $visite->id }}</td>
                                <td>
                                    @if($visite->user)
                                        {{ $visite->user->nom }} {{ $visite->user->prenom }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $visite->client->nom }} {{ $visite->client->prenom }}</td>
                                <td>{{ $visite->date_arrivee }}</td>
                                <td>{{ $visite->date_sortie ?? '-' }}</td>
                                <td>{{ $visite->motif }}</td>
                                <td>
                                    @if ($visite->statut === 'EN_COURS')
                                        <span class="badge bg-warning">En cours</span>
                                    @else
                                        <span class="badge bg-success">Terminée</span>
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
@endsection
