@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="card">

            <div class="card-img">
                <img src="{{ asset('assets/images/user-default.png') }}" alt="profile">
            </div>

            <div class="desc">
                <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>

                <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ?? 'Non renseignée' }}</p>

            </div>

            <div class="details">

                <div class="parents">
                    <h2>Parents  <i class='bx bx-child'></i></h2>
                    <ul>
                        @forelse($person->parents as $parent)
                            <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
                        @empty
                            <li>Aucun parent enregistré</li>
                        @endforelse
                    </ul>

                </div>

                <div class="enfants">
                    <h2>Enfants  <i class='bx bx-child'></i></h2>
                    <ul>
                        @forelse($person->children as $child)
                            <li>{{ $child->first_name }} {{ $child->last_name }}</li>
                        @empty
                            <li>Aucun enfant enregistré</li>
                        @endforelse
                    </ul>

                </div>


            </div>



            <a href="{{ route('people.index') }}" class="btn btn-secondary">Retour à la liste</a>
        </div>

    </div>
@endsection
