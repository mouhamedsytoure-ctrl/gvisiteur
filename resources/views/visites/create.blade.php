@extends('layouts.app')

@section('title', 'Nouvelle visite')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Nouvelle visite</h3>
        <a href="{{ route('visites.index') }}" class="btn btn-outline-light">← Retour</a>
    </div>

    <div class="card card-dark p-4">

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('visites.store') }}" method="POST" autocomplete="off" id="form-visite">
            @csrf

            {{-- CLIENT --}}
            <div class="mb-3">
                <label class="form-label">Client</label>
                <select name="client_id" class="form-select" required>
                    <option value="">-- Sélectionner un client --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->nom }} {{ $client->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NOM DU VISITEUR --}}
            <div class="mb-3">
                <label class="form-label">Nom du visiteur</label>
                <input type="text" name="nom_visiteur" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date & heure d'arrivée</label>
                    <input type="datetime-local" name="date_arrivee" id="date_arrivee" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date & heure de sortie (auto-remplie à +1h)</label>
                    <input type="datetime-local" name="date_sortie" id="date_sortie" class="form-control" readonly style="background-color: #f0f0f0;">
                    <small class="text-muted d-block mt-1">
                        Se remplit automatiquement 1h après l'arrivée.
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Motif</label>
                <textarea name="motif" rows="3" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Personne rencontrée</label>
                <input type="text" name="personne_rencontree" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    <option value="EN_COURS">En cours</option>
                    <option value="TERMINEE">Terminée</option>
                </select>
                <small class="text-muted d-block mt-1">
                    Se change automatiquement en "Terminée" après 1h d'arrivée.
                </small>
            </div>

            <button class="btn btn-accent" type="submit">Enregistrer la visite</button>

        </form>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateArriveeInput = document.getElementById('date_arrivee');
        const dateSortieInput = document.getElementById('date_sortie');
        const statutInput = document.getElementById('statut');

        function addOneHour(dateStr) {
            const date = new Date(dateStr);
            const oneHourLater = new Date(date.getTime() + 60 * 60 * 1000);

            const year = oneHourLater.getFullYear();
            const month = String(oneHourLater.getMonth() + 1).padStart(2, '0');
            const day = String(oneHourLater.getDate()).padStart(2, '0');
            const hours = String(oneHourLater.getHours()).padStart(2, '0');
            const minutes = String(oneHourLater.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        dateArriveeInput.addEventListener('change', function () {
            if (this.value) {
                dateSortieInput.value = addOneHour(this.value);
            }
        });

        function checkElapsedTime() {
            if (!dateArriveeInput.value) return;

            const arrivee = new Date(dateArriveeInput.value);
            const maintenant = new Date();
            const diffMs = maintenant - arrivee;
            const diff1h = 60 * 60 * 1000;

            if (diffMs >= diff1h && statutInput.value !== 'TERMINEE') {
                statutInput.value = 'TERMINEE';
            }
        }

        setInterval(checkElapsedTime, 5000);
    });
</script>

@endsection
