<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Découvrir les meilleurs spots de Marrakech')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
  .navbar{
    background:#A45A2A !important;
    padding:12px 35px;
    box-shadow:0 4px 15px rgba(0,0,0,.12);
}

.nav-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.brand-logo{
    width:52px;
    height:52px;
    object-fit:contain;
    margin-right:14px;
    flex-shrink:0;
}
.brand-text h1{
    margin:0;
    font-size:28px;
    font-weight:700;
    color:#fff;
    line-height:1.1;
}

.brand-text p{
    margin:2px 0 0;
    font-size:11px;
    color:#F7DFA7;
    letter-spacing:1px;
}

.nav-right{
    display:flex;
    align-items:center;
    gap:14px;
}

.nav-link-custom{
    color:white;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:6px;
    font-weight:600;
    padding:8px 14px;
    border-radius:25px;
    transition:.3s;
}

.nav-link-custom:hover{
    background:rgba(255,255,255,.15);
    color:white;
}

.nav-link-custom.active{
    background:white;
    color:#A45A2A;
}

@media (max-width: 991.98px) {
    .navbar {
        padding: 12px 20px;
    }
    .nav-right {
        flex-direction: column;
        align-items: stretch !important;
        width: 100%;
        gap: 10px !important;
        margin-top: 15px;
    }
    .nav-link-custom {
        display: flex;
        width: 100%;
    }
    .search-container {
        width: 100%;
    }
    .search-input {
        width: 100% !important;
    }
}

.search-container{
    display:flex;
    align-items:center;
    background:#ffffff;
    border-radius:30px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.3);
}

.search-input{
    width:200px;
    border:none;
    outline:none;
    padding:8px 15px;
    font-size:14px;
    background:transparent;
}

.search-input::placeholder{
    color:#999;
}

.search-btn{
    border:none;
    background:transparent;
    color:#8B4513;
    padding:8px 15px;
    cursor:pointer;
    transition:.3s;
}

.search-btn:hover{
    color:#C96A2B;
}

.search-icon{
    position:absolute;
    right:12px;
    top:9px;
    color:#A45A2A;
}

.notification-btn{
    width:40px;
    height:40px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    color:white;
}

.user-profile{
    width:42px;
    height:42px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid rgba(255,255,255,.4);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:15px;
    font-weight:700;
    flex-shrink:0;
}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-0">
        <a class="nav-left navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="brand-logo" alt="Marrakech Tour">
            <div class="brand-text">
                <h1 class="mb-0 text-white" style="font-size: 24px;">Marrakech Tour</h1>
                <p class="mb-0" style="color: #F7DFA7; font-size: 11px;">Explore • Discover • Enjoy</p>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#marrakechCrudNavbar" aria-controls="marrakechCrudNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="marrakechCrudNavbar">
            <div class="nav-right ms-auto d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-3 mt-3 mt-lg-0 w-100 justify-content-end">
                <a href="{{ route('home') }}"
                   class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    Accueil
                </a>

                <a href="{{ route('attractions.index') }}"
                   class="nav-link-custom {{ request()->routeIs('attractions.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    Attractions
                </a>

                @role('Admin')
                    <a href="{{ route('dashboard') }}"
                       class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                @endrole

                <form action="{{ route('attractions.index') }}" method="GET" class="search-container mb-0">
                    <input type="hidden" name="type" value="{{ request('type') }}">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Rechercher une attraction..."
                        value="{{ request('search') }}">
                    <button type="submit" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                @auth
                    <div class="dropdown">
                        <button class="notification-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill"></i>
                            @if($notificationCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $notificationCount }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="width:320px; max-width: 100vw;">
                            @forelse($notifications as $notification)
                                <li class="px-3 py-2 border-bottom">
                                    <strong>{{ $notification->data['title'] }}</strong>
                                    <br>
                                    <div class="small text-muted">{{ $notification->data['message'] }}</div>
                                    <small class="text-secondary">
                                        <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </li>
                            @empty
                                <li class="text-center py-3 text-muted">Aucune notification.</li>
                            @endforelse
                            @if($notificationCount > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-center">
                                            <i class="bi bi-check2-all"></i> Tout marquer comme lu
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="user-profile" alt="Profil">
                        @else
                            <div class="user-profile d-flex justify-content-center align-items-center fw-bold bg-warning text-dark">
                                {{ collect(explode(' ', auth()->user()->name))->map(fn($word)=>strtoupper(substr($word,0,1)))->take(2)->implode('') }}
                            </div>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="nav-link-custom mb-0 text-white py-1">
                            {{ auth()->user()->name }}
                        </a>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-light btn-sm w-100">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="nav-link-custom">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>
<main>
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
