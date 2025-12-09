@component('mail::message')
# Réinitialisation du mot de passe

Vous avez demandé la réinitialisation de votre mot de passe.  
Cliquez sur le bouton ci‑dessous pour définir un nouveau mot de passe. Le lien expire dans 24 heures.

@component('mail::button', ['url' => route('password.reset-form', $token)])
Réinitialiser mon mot de passe
@endcomponent

Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.

Merci,<br>
{{ config('app.name') }}
@endcomponent