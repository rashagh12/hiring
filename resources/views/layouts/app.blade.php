<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>HIREEASILY</title>
    <meta name="description" content="A platform for finding and posting jobs effortlessly"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="pinterest" content="nopin"/>

    <!-- Fonts and Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style1.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">HIREEASILY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('jobs.index') }}">Find Jobs</a>
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
                        @if (Auth::user()->role == 'admin')
                            <a class="btn outline me-2 d-flex justify-content-end" href="{{ route('admin.dashboard') }}"
                               type="submit">Admin</a>
                        @else
                            <li class="nav-link d-flex justify-content-end">
                                <a id="navbarDropdown" class="nav-link" href="{{ route('account.profile') }}"
                                   role="button">
                                    {{ Auth::user()->name }}
                                    <i class="bi bi-person-circle"></i>
                                </a>
                            </li>
                        @endif
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>

<div>
    <!-- Display all errors -->
    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Display session messages -->
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @yield('main')
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="ProfilePicForm" id="ProfilePicForm" action="{{ route('account.updateProfilePic') }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn Explore mx-3">Update</button>
                        <button type="button" class="btn outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer pt-5 pb-5 text-light text-center text-md-start bg-dark">
    <div class="container d-flex flex-wrap">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h2 class="text-light">HIREEASILY</h2>
                <p class="mb-3 text-light lh-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente
                    accusantium maxime, expedita optio atque cum unde quis pariatur necessitatibus suscipit porro
                    totam?</p>
                <div class="copyright">
                    Created By ARAM
                    <div>&copy; 2024 - HIREEASILY</div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <h2 class="text-light">Links</h2>
                <ul class="text-light list-unstyled lh-lg">
                    <li><a href="#" class="nav-link text-light">Home</a></li>
                    <li><a href="#" class="nav-link text-light">Jobs</a></li>
                    <li><a href="#" class="nav-link text-light">Support</a></li>
                    <li><a href="#" class="nav-link text-light">Login</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-lg-2">
                <h2 class="text-light">About us</h2>
                <ul class="text-light list-unstyled lh-lg">
                    <li><a href="#" class="nav-link text-light mt-2">Register</a></li>
                    <li><a href="#" class="nav-link text-light mt-2">About us</a></li>
                    <li><a href="#" class="nav-link text-light mt-3">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="contact">
                    <h2 class="text-light">Contact Us</h2>
                    <p class="mb-3 text-light lh-lg">Lorem ipsum dolor sit amet consectet it odit quo, cs ad libero
                        quisquam nam.</p>
                    <a class="btn Explore rounded-pill main-btn w-100 text-light" href="mailto:HIREEASILY@gmail.com">HIREEASILY@gmail.com</a>
                    <ul class="d-flex mt-3 list-unstyled gap-4">
                        <li><a class="d-block text-light" href="#"><i class="fa-lg bi bi-facebook"></i></a></li>
                        <li><a class="d-block text-light" href="#"><i class="fa-lg bi bi-messenger"></i></a></li>
                        <li><a class="d-block text-light" href="#"><i class="fa-lg bi bi-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@yield('customJs')
</body>
</html>
