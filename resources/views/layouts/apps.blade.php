<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>HIREESAILY</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style1.css") }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">HIREESAILY</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('jobs') }}">Find Jobs</a>
                        </li>
                    </ul>
                    @guest

                    @if (Route::has('login'))
                    <a class="btn outline me-2" href="{{ route('login') }}" type="submit">{{ __('Login') }}</a>
                    @endif

                    @if (Route::has('register'))
                    <a class="btn Explore" href="{{ route('register') }}" type="submit">{{ __('Register') }}</a>
                    @endif
                    @else
                    <div class="d-flex justify-content-end">
                        
                    {{-- <li class="nav-link " class="d-flex justify-content-end">
                        <a id="navbarDropdown" class="nav-link" href="{{ route('account.profile') }}" role="button" >
                            {{ Auth::user()->name }}
                            <i class="bi bi-person-circle"></i>
                        </a> --}}
                        @if (Auth::user()->role =='admin')
                        <a class="btn outline me-2 d-flex justify-content-end " href="{{ route('admin.dashboard') }}" type="submit">Admin</a>				
                        @else
                        <li class="nav-link " class="d-flex justify-content-end">
                            <a id="navbarDropdown" class="nav-link" href="{{ route('account.profile') }}" role="button" >
                                {{ Auth::user()->name }}
                                <i class="bi bi-person-circle"></i>
                            </a>
                        @endif
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    </li>
                @endguest
                </div>
            </div>
        </nav>
    </header>

    <div>
        @yield('main')
    </div>



        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>


        @yield('customJs')
</body>
</html>
