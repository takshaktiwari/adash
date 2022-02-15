<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Adash</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{ $slot }}
</body>
</html>