<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>HIREEASILY</title>
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
                <a class="navbar-brand" href="{{ route('home') }}">HIREEASELY</a>
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
    {{-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

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
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        
    </div> --}}
    <div>
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
            <form name="ProfilePicForm" id="ProfilePicForm" action="{{ route('account.updateProfilePic') }}" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    @csrf
                    <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="image"  name="image">
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


    {{-- model for cv --}}
    <div class="modal fade" id="exampleModalcv" tabindex="-1" aria-labelledby="exampleModalLabelcv" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pb-0" id="exampleModalLabelcv">Upload your CV</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form name="ProfilePicForm" id="ProfilePicForm" action="{{ route('account.updateProfilecv') }}" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    @csrf
                    {{-- <div class="mb-3">
                        <label for=""  class="form-label">Your name*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"  required name="name" id="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for=""  class="form-label"  >Your Marital Status*</label>
                        <select name="marital" id="marital" class="form-control">
                            @foreach ($maritalstatus as $maritalstatu)
                            <option value="{{ $maritalstatu->id }}">{{ $maritalstatu->name }}</option>
                            @endforeach
                    
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for=""  class="form-label"  >Your Age*</label>
                        <input type="text" class="form-control  @error('age') is-invalid @enderror"  required  name="age" id="age">

                        @error('age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <label for="cv" class="form-label">Enter Your CV</label>
                    <input type="file" class="form-control" id="cv"  name="cv">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn Explore mx-3">Upload</button>
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
                    <h2 class="text-light">
                        HIREEASILY
                    </h2>
                    <p class="mb-3 text-light lh-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente accusantium maxime, expedita op ditate cum unde quis pariatur necessitatibus suscipit porro totam?</p>
                    <div class="copyright">
                        Created By ARAM
                        <div>&copy; 2024 - HIREEASILY</div>
                    </div>
                </div>
                <div class="col-md-4  col-lg-2">
                    <h2 class="text-light">Links </h2>
                    <ul class="text-light list-unstyeld lh-lg ">
                        <li><a href="" class="nav-link text-light ">Home</a></li>
                        <li><a href="" class="nav-link text-light ">Jobs</a></li>
                        <li><a href="" class="nav-link text-light ">Support</a></li>
                        <li><a href="" class="nav-link text-light ">Login </a></li>
                    </ul>
                </div>
                <div class="col-md-4  col-lg-2">
                    <h2 class="text-light">About us </h2>
                    <ul class="text-light list-unstyeld lh-lg">
                        <li><a href="" class="nav-link text-light  mt-2">Regitser</a></li>
                        <li><a href="" class="nav-link text-light mt-2">About us</a></li>
                        <li><a href="" class="nav-link text-light mt-3">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="contact">
                        <h2 class="text-light">Contact Us</h2>
                        <p class="mb-3 text-light lh-lg">Lorem ipsum dolor sit amet consectet it odit quo, cs ad libero quisquam nam.</p>
                        <a class="btn  Explore rounded-pill main-btn w-100 text-light" href="">HIREEASILY@gmail.com</a>
                        <ul class="d-flex mt-3 list-unstyled gap-4">
                            <li><a class="d-block text-light" href="">
                                <i class="fa-lg bi bi-facebook"></i>
                            </a></li>
                            <li><a class="d-block text-light" href="">
                                <i class="fa-lg bi bi-messenger "></i>
                            </a></li>
                            <li><a class="d-block text-light" href="">
                                <i class="fa-lg bi bi-linkedin"></i>
                            </a></li>
                        </ul>
                    </div>
                </div>
            
                {{-- <div class="footer-col">
                    <h4>
                        Hiring
                    </h4>
                    <l>
                        <li>
                            <a href="#">about us</a>
                        </li>
                        <li>
                            <a href="">our services</a>
                        </li>
                        <li><a href="">privacy policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>get help
                    </h4>
                    <ul>
                        <li><a href="">FAQ</a></li>
                        
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="text-light">Follow us
                    </h4>
                    <div class="social-links">
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-envelope-at-fill"></i></a>
                        <a href=""><i class="bi bi-messenger"></i></a>
                    </div>
                </div> --}}
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
