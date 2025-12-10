@extends('layouts.app')

@section('title', 'Aide – GVisiteur')

@section('content')
<div class="container-fluid py-4">

    <h2 class="mb-2">Centre d’aide – GVisiteur</h2>
    <p class="text-muted mb-4">Guide rapide pour comprendre et bien utiliser l’application.</p>

    <div class="card card-dark p-4">

        {{-- ================================
             1. Connexion & Rôles
        ================================= --}}
        <h4>1. Connexion & Rôles utilisateurs</h4>
        <p class="text-muted">
            L’accès à GVisiteur est réservé aux comptes enregistrés (Administrateur & Secrétaire).
        </p>

        <ul>
            <li><strong>Administrateur :</strong> gère les utilisateurs, les clients, les visites, et accède aux historiques.</li>
            <li><strong>Secrétaire :</strong> enregistre les visites, consulte l’historique, gère les clients.</li>
        </ul>

        <hr>

        {{-- ================================
             2. Gestion des clients
        ================================= --}}
        <h4>2. Gestion des clients</h4>

        <p>Dans le menu <strong>Clients</strong> :</p>

        <ul>
            <li><strong>Ajouter un client</strong> : utiliser le formulaire à gauche.</li>
            <li><strong>Liste des clients</strong> : affichée à droite.</li>
            <li><strong>Clic sur un client</strong> : affiche ses informations complètes.</li>
            <li><strong>Modifier / Supprimer</strong> : boutons d’action à droite.</li>
        </ul>

        <hr>

        {{-- ================================
             3. Enregistrement des visites
        ================================= --}}
        <h4>3. Enregistrement des visites</h4>

        <p>Dans la page <strong>Visites</strong> :</p>

        <ul>
            <li>Le formulaire à gauche permet d’enregistrer une nouvelle visite.</li>
            <li><strong>Nom du visiteur</strong> : obligatoire.</li>
            <li><strong>Client visité</strong> : obligatoire.</li>
            <li><strong>Date d’arrivée</strong> : obligatoire.</li>
            <li><strong>Date de sortie</strong> : facultative, ou ajoutée automatiquement dans certains cas.</li>
        </ul>

        <p class="mt-2"><strong>Important :</strong> en cliquant sur une ligne de l’historique, tu vois les détails de la visite.</p>

        <hr>

        {{-- ================================
             4. Historique & Recherche
        ================================= --}}
        <h4>4. Historique des visites</h4>

        <p>L’historique affiche les visites enregistrées.</p>

        <ul>
            <li><strong>Clic sur une visite</strong> → détails complets (client visité, heures, motif).</li>
            <li><strong>Recherche en direct</strong> → tape un nom pour filtrer instantanément.</li>
            <li><strong>Statuts :</strong> <em>En cours</em>, <em>Terminée</em>.</li>
        </ul>

        <hr>

        {{-- ================================
             5. Rapports & PDF
        ================================= --}}
        <h4>5. Rapports & PDF</h4>

        <p>Dans le menu <strong>Rapports</strong> :</p>

        <ul>
            <li>Tu peux filtrer les visites par <strong>date de début</strong> et <strong>date de fin</strong>.</li>
            <li>Bouton <strong>Imprimer</strong> → imprime la page directement.</li>
            <li>Bouton <strong>Télécharger en PDF</strong> → export propre pour archivage.</li>
        </ul>

        <hr>

        {{-- ================================
             6. Administration
        ================================= --}}
        <h4>6. Administration (Admin uniquement)</h4>

        <ul>
            <li>Historique des actions des secrétaires</li>
            <li>Consultation des utilisateurs</li>
            <li>Gestion des comptes si activé</li>
        </ul>

        <hr>

        {{-- ================================
             7. Déconnexion
        ================================= --}}
        <h4>7. Déconnexion</h4>

        <p>
            Utilise le bouton <strong>Déconnexion</strong> en haut à droite pour fermer ta session en toute sécurité.
        </p>

        <hr>

        {{-- ================================
             8. Support technique
        ================================= --}}
        <h4>8. Support technique</h4>

        <p>
            En cas de bug, problème d’accès ou demande d’amélioration :
            <br>
            <strong>Email :</strong> support@gvisiteur.com (exemple)
            <br>
            <strong>Téléphone :</strong> +221 xx xxx xx xx
            <br><br>
            Ou contacte directement l’administrateur interne.
        </p>

    </div>

</div>
@endsection
