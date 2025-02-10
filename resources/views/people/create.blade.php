@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
    <div class="content">



        <form action="{{ route('people.store') }}" method="POST" class="form">
            @csrf
            <h3>Ajouter une nouvelle personne</h3>

            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Nom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="birth_name">Nom de naissance</label>
                <input type="text" class="form-control" id="birth_name" name="birth_name">
            </div>

            <div class="form-group">
                <label for="middle_names">Autres prénoms</label>
                <input type="text" class="form-control" id="middle_names" name="middle_names">
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date de naissance</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
            <br>
            <a href="{{ route('people.index') }}" class="">Revenir à la liste </a>
        </form>
    </div>
@endsection
