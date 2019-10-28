<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Maktabaty') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bookDetails.css') }}" rel="stylesheet">
    <style>
            html, body {
                background-color: #EFC070;
                font-family: 'Nunito', sans-serif;
                height: 100vh;
                margin: 0;
            }
    </style> 


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}" id='home'>
                    Home
                </a>
                <a class="navbar-brand" href="{{ url('/user/0') }}" id='allBooks'>
                    All Books
                </a>
                <a class="navbar-brand" href="{{ url('/leased/0') }}" id='leasedBooks'>
                    Leased Books
                </a>
                <a class="navbar-brand" href="{{ url('/favourite/0') }}" id='favBooks'>
                    Favourite Books
                </a>
                    <ul class="navbar-nav ml-auto">
                        @guest

                        @else
                            <div class="profile-header-img">
                                <img class="rounded-circle" src="{{ Auth::user()->user_image }}" style="width:50px; height:50px; float:left; border-radius:50%; margin-right:25px;"/>
                            </div>

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
