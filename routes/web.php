<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Page d'accueil : redirige vers le login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login.form');
});

/*
|--------------------------------------------------------------------------
| Authentification (admin / secrétaire)
|--------------------------------------------------------------------------
*/

// Formulaire de connexion
Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login.form');

// Traitement du login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Formulaire d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register.form');

// Traitement du formulaire d'inscription
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Récupération de mot de passe oublié
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.send-reset-link');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

/*
|--------------------------------------------------------------------------
| Routes protégées (auth obligatoire)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Tableau de bord dynamique
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // CRUD Clients
    Route::resource('clients', ClientController::class);

    // CRUD Visites
    Route::resource('visites', VisiteController::class);

    /*
    |--------------------------------------------------------------------------
    | SECTION ADMIN UNIQUEMENT
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/admin/historique-secretaires',
        [AdminController::class, 'historiqueSecretaires']
    )->name('admin.historique.secretaires');
});