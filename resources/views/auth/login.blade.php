@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="form-box login">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Connexion</h1>
                   @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif
                <div class="input-box">
                    <input type="email" name="email" id="email" required autofocus placeholder="Email">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" required placeholder="Mot de passe">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div>
                    <button type="submit" class="btn">Se connecter</button>
                </div>
            </form>

        </div>
        <div class="form-box register">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Inscription</h1>
                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- sucess message session flash --}}
                
                
               @if(Session::has('success'))
               <div class="sucess-box">
                <p class="success">{{ Session::get('success') }}</p>
               </div>
@endif
                <div class="input-box">
                    <input type="text" name="name" id="name" required autofocus placeholder="Nom d'utilisateur">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" id="email" required autofocus placeholder="Email">
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" required placeholder="Mot de passe">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        placeholder="Confirmer Mot de passe">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div>
                    <button type="submit" class="btn">S'inscrire</button>
                </div>
            </form>
        </div>
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Bienvenu à nouveau !</h1>
                <p>Vous n'avez pas de compte ?</p>
                <button class="btn btn-register" >S'inscrire</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1> Bonjour, Bienvenu </h1>
                <p>Vous avez  déjà un compte ?</p>
                <button class="btn btn-login" >Connexion</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
