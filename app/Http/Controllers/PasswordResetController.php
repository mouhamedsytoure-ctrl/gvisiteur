<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class PasswordResetController extends Controller
{
    /**
     * Affiche le formulaire de demande de réinitialisation.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Traite la demande de réinitialisation et envoie le mail.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Génère un token non hashé pour l'email ; on stocke la version hashée pour sécurité.
        $plainToken = Str::random(60);

        $user->update([
            'password_reset_token'   => Hash::make($plainToken),
            'password_reset_expires' => Carbon::now()->addHours(24),
        ]);

        // Envoi du mail (utilise la Mailable ResetPasswordMail)
        Mail::to($user->email)->send(new ResetPasswordMail($plainToken));

        return redirect()
            ->route('login.form')
            ->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }

    /**
     * Affiche le formulaire de réinitialisation (avec token dans l'URL).
     */
    public function showResetForm($token)
    {
        // Recherche l'utilisateur dont le token stocké correspond (et non expiré)
        $possible = User::whereNotNull('password_reset_token')
            ->where('password_reset_expires', '>', Carbon::now())
            ->get();

        $user = $possible->first(function ($u) use ($token) {
            return Hash::check($token, $u->password_reset_token);
        });

        if (! $user) {
            return redirect()->route('login.form')->with('error', 'Lien de réinitialisation invalide ou expiré.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    /**
     * Traite la réinitialisation du mot de passe.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users,email',
            'token'                 => 'required',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user
            || ! $user->password_reset_token
            || ! Hash::check($request->token, $user->password_reset_token)
            || $user->password_reset_expires < Carbon::now()
        ) {
            return back()->with('error', 'Lien invalide ou expiré.')->withInput();
        }

        $user->update([
            'password'               => Hash::make($request->password),
            'password_reset_token'   => null,
            'password_reset_expires' => null,
        ]);

        return redirect()->route('login.form')->with('success', 'Mot de passe réinitialisé. Vous pouvez maintenant vous connecter.');
    }
}