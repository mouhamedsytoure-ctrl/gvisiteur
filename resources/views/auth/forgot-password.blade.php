@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="container" style="max-width:520px;margin:48px auto;">
    <div class="card card-dark p-4">
        <h4 class="mb-3">Mot de passe oublié</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <form action="{{ route('password.send-reset-link') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <button class="btn btn-accent" type="submit">Envoyer le lien</button>
            <a href="{{ route('login.form') }}" class="btn btn-link">← Retour</a>
        </form>
    </div>
</div>
@endsection