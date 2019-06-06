<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xadrez CRUD') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/open-iconic/font/css/open-iconic.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/shared.css' )}}" rel="stylesheet">
    @section('header')
    @show
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container" style="width: 100%;max-width: unset;">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Xadrez CRUD') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li>
                        @guest
                        @else
                            <li>
                                <a href="/usuarios" class="nav-link"> Usuários </a>
                            </li>
                            <li>
                                <a href="/jogadores" class="nav-link"> Jogadores </a>
                            </li>
                            <li>
                                <a href="/tipos_de_partida" class="nav-link"> Tipos de partida </a>
                            </li>
                            <li>
                                <a href="/controles_de_tempo" class="nav-link"> Controles de tempo </a>
                            </li>
                            <li>
                                <a href="/partidas" class="nav-link"> Partidas </a>
                            </li>
                            <li>
                                <a href="/aberturas" class="nav-link"> Aberturas </a>
                            </li>
                            <li>
                                <a href="/momentos_partida" class="nav-link"> Momentos partida </a>
                            </li>
                            <li>
                                <a href="/avaliacoes_lance" class="nav-link"> Avaliações de lances </a>
                            </li>
                            <li>
                                <a href="/lances" class="nav-link"> Lances </a>
                            </li>
                            <li>
                                <a class="nav-link"> Variações de rating </a>
                            </li>
                        @endguest
                            
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
