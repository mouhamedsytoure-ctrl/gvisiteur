@extends('layouts.app')

@section('title', 'Accueil – Gestion des visites')

@section('content')
<div class="container-fluid py-5">

    <style>
        .home-wrapper {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-home {
            background-color: #ffffff;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
        }
        .home-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #111827;
        }
        .home-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
        }
        .home-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(218, 165, 32, 0.08);
            color: #92400e;
        }
        .btn-primary-soft {
            background: #111827;
            color: #f9fafb;
            border-radius: 999px;
            padding: 10px 22px;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
        }
        .btn-primary-soft:hover {
            background: #020617;
            color: #fff;
        }
        .btn-outline-soft {
            border-radius: 999px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .small-muted {
            color: #6b7280;
            font-size: 13px;
        }
    </style>

    <div class="home-wrapper">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-lg-7 col-xl-6">
                <div class="card card-home p-4 p-lg-5">

                    <span class="home-badge mb-3">
                        Gestion des visites & secrétariat
                    </span>

                    <h1 class="home-title mb-2">
                        Bienvenue dans le portail des visites
                    </h1>

                    <p class="home-subtitle mb-4">
                        Centralisez l’enregistrement des visiteurs, suivez les passages
                        des clients et visualisez les statistiques clés du secrétariat
                        en quelques clics.
                    </p>

                    @auth
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                            <a href="{{ route('dashboard') }}"
                               class="btn btn-primary-soft">
                                Accéder au tableau de bord
                            </a>

                            @if(Route::has('visites.historique'))
                                <a href="{{ route('visites.historique') }}"
                                   class="btn btn-outline-soft btn-sm btn-outline-secondary">
                                    Historique des secrétaires
                                </a>
                            @endif
                        </div>

                        <p class="small-muted mb-0">
                            Vous êtes connecté en tant que
                            <strong>{{ Auth::user()->name ?? Auth::user()->email }}</strong>.
                        </p>
                    @else
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-primary-soft">
                                    Se connecter
                                </a>
                            @endif

                            @if(Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="btn btn-outline-soft btn-outline-secondary">
                                    Créer un compte
                                </a>
                            @endif
                        </div>

                        <p class="small-muted mb-0">
                            Connectez-vous pour accéder au tableau de bord, gérer les visites
                            et consulter l’historique des secrétaires.
                        </p>
                    @endauth

                    <hr class="my-4">

                    <div class="d-flex flex-wrap justify-content-between small-muted">
                        <div>
                            • Suivi des visites en temps réel<br>
                            • Statistiques hebdomadaires et mensuelles<br>
                            • Historique par secrétaire
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge bg-light text-muted">
                                Version interne – Secrétariat
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
