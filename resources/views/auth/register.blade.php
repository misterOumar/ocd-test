@extends('layouts.app')

@section('content')
<h2>Inscription</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" required autofocus>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>
    <div>
        <button type="submit">S'inscrire</button>
    </div>
</form>
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
