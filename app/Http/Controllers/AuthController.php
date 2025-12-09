<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['email' => 'Identifiants incorrects'])
            ->withInput();
    }

    /**
     * Affiche le formulaire d'inscription.
     * Un user peut être admin ou secretaire.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:admin,secretaire',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login.form')
            ->with('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
