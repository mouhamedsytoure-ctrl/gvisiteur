@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="container" style="max-width:520px;margin:48px auto;">
    <div class="card card-dark p-4">
        <h4 class="mb-3">Réinitialiser le mot de passe</h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.reset') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" required readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-accent" type="submit">Réinitialiser</button>
            <a href="{{ route('login.form') }}" class="btn btn-link">← Retour</a>
        </form>
    </div>
</div>
@endsection