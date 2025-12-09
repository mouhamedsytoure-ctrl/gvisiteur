@extends('layouts.app')

@section('title', 'Modifier un client – Gestion des visites')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Modifier le client</h3>
            <p class="text-muted mb-0">Mettre à jour les informations du client.</p>
        </div>
        <div>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-light">
                ← Retour à la liste
            </a>
        </div>
    </div>

    <div class="card card-dark p-4">
        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clients.update', $client) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text"
                           name="nom"
                           id="nom"
                           value="{{ old('nom', $client->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text"
                           name="prenom"
                           id="prenom"
                           value="{{ old('prenom', $client->prenom) }}"
                           class="form-control @error('prenom') is-invalid @enderror"
                           required>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text"
                           name="telephone"
                           id="telephone"
                           value="{{ old('telephone', $client->telephone) }}"
                           class="form-control @error('telephone') is-invalid @enderror"
                           required>
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $client->email) }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="entreprise" class="form-label">Entreprise</label>
                    <input type="text"
                           name="entreprise"
                           id="entreprise"
                           value="{{ old('entreprise', $client->entreprise) }}"
                           class="form-control @error('entreprise') is-invalid @enderror">
                    @error('entreprise')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-accent">
                Mettre à jour
            </button>
        </form>
    </div>
</div>
@endsection
