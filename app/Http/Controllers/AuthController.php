<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Affiche la page de connexion.
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Vérifie l'identité de l'utilisateur.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }

    /**
     * Déconnexion.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
