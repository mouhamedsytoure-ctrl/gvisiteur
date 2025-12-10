<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RapportController;


Route::get('/', function () {
    return redirect()->route('login.form');
});



Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login.form');


Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register.form');


Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');


Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.forgot');


Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.send-reset-link');


Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset-form');


Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.reset');


Route::middleware('auth')->group(function () {

    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    
    Route::resource('clients', ClientController::class);

    
    Route::resource('visites', VisiteController::class);

    
    Route::get('/rapports', [RapportController::class, 'index'])
        ->name('rapports.index');

   
    Route::get('/rapports/pdf', [RapportController::class, 'exportPdf'])
        ->name('rapports.pdf');

    Route::view('/aide', 'aide.index')->name('help.index');

    Route::get(
        '/admin/historique-secretaires',
        [AdminController::class, 'historiqueSecretaires']
    )->name('admin.historique.secretaires');

});
