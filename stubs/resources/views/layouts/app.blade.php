<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/app/css/app.css', 'resources/app/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        .lc-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .lc-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .lc-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .lc-4 { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Navigation Hover Fix */
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fff !important;
            transition: color 0.3s ease;
        }
        .navbar-dark .navbar-nav .nav-link.active {
            color: var(--bs-primary) !important;
        }
    </style>

    @stack('styles')
</head>

<body>
    <x-alertt-alert />
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                <span class="text-primary">A</span>dash
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-lg-3">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link btn btn-outline-light px-4 rounded-pill dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Admin Panel</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="nav-link px-4" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary px-4 rounded-pill text-white" href="{{ route('register') }}">Get Started</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-dark text-light py-5 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">Adash</h5>
                    <p class="text-secondary small">
                        A powerful Laravel package for building modern administration dashboards and landing pages with ease.
                    </p>
                </div>
                <div class="col-lg-2 ms-auto">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="https://github.com/takshaktiwari/adash" class="text-secondary text-decoration-none">Documentation</a></li>
                        <li class="mb-2"><a href="https://github.com/takshaktiwari/adash/issues" class="text-secondary text-decoration-none">Report Issue</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-secondary small">
                        &copy; {{ date('Y') }} Adash. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="mb-0 text-secondary small">
                        Crafted with <i class="bi bi-heart-fill text-danger"></i> by <a href="https://github.com/takshaktiwari" class="text-light text-decoration-none fw-bold">takshaktiwari</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>
