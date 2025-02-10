@extends('layouts.app')

@section('content')
    <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>

    <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ?? 'Non renseignée' }}</p>

    <h2>Parents</h2>
    <ul>
        @forelse($person->parents as $parent)
            <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
        @empty
            <li>Aucun parent enregistré</li>
        @endforelse
    </ul>

    <h2>Enfants</h2>
    <ul>
        @forelse($person->children as $child)
            <li>{{ $child->first_name }} {{ $child->last_name }}</li>
        @empty
            <li>Aucun enfant enregistré</li>
        @endforelse
    </ul>

    <a href="{{ route('people.index') }}" class="btn btn-secondary">Retour à la liste</a>
@endsection
