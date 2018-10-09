<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- CK editor --}}
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>

    {{-- Datatables --}}
    <script src="{{ asset('DataTables/datatables.js') }}" defer></script>

    {{-- Highcharts --}}
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>


    <style>
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    </style>
    
</head>
<body>
    <div id="app">{{-- #008B8B; --}}
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel bg-dark" style="min-height:100px">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="color:white;">
                    <h2>EduApp</h2>
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="icon-bar">+</span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                           
                        @else
                             @if(Auth::user()->role == 'coordinator')
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/categories">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/courses">Courses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/results">Results</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="category" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        HOcusPocus </a>
                                    <div class="dropdown-menu" aria-labelledby="category">
                                        <a class="dropdown-item" href="/categories">View</a>
                                        <a class="dropdown-item" href="/categories/create">Create</a>
                                    </div>
                                </li>

                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                {{-- <input type="button" class="btn btn-success btn-md" value="Login" onclick="location.href ='{{ route('login') }}'"> --}}
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                               {{-- <input type="button" class="btn btn-primary btn-md" value="Register" onclick="location.href ='{{ route('register') }}'"> --}}
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
            <div class="container{{-- -fluid --}}">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @include('inc.message')
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
		CKEDITOR.replace( 'editor1' );
	</script>
</body>
</html>
