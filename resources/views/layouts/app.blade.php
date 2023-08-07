<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AICS Online Application</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles
    <style>
        @import url('node_modules/material-design-icons-iconfont/dist/material-design-icons.css');
      </style> -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!--<link href="https://cdn.jsdelivr.net/npm/mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">-->

    @routes()
</head>

<body>

    <div id="app" data-app>
        <v-app>
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm d-print-none">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img max-height="64" max-width="250px" src="/images/DSWD-DVO-LOGO.png" class="img-fluid"  style="height: 50px;"/>
                        
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                <!--if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{ route('register') }}">{ __('Register') }}</a>
                                        </li>
                                    endif-->
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
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
        </v-app>
    </div>

</body>

</html>
