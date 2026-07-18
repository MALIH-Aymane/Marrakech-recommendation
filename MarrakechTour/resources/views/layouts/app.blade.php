@php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp
<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.2/build/css/intlTelInput.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','Découvrir les meilleurs spots de Marrakech')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

body{
    font-family:'Poppins',sans-serif;
    background:#f8f4ef;
    margin:0;
}

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
}

.brand-text h1{
    margin:0;
    font-size:28px;
    color:white;
}

.brand-text p{
    margin:0;
    color:#F7DFA7;
    font-size:12px;
}

.nav-right{
    display:flex;
    align-items:center;
    gap:16px;
}

.nav-link-custom{
    text-decoration:none;
    color:white;
    font-weight:600;
    padding:8px 15px;
    border-radius:30px;
    transition:.3s;
    display:inline-block;
}

.nav-link-custom:hover{
    color:white;
    background:rgba(255,255,255,.15);
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
        display: block;
        width: 100%;
    }
}

main{
    min-height:80vh;
}

footer{
    background:#8B4513;
    color:white;
    text-align:center;
    padding:20px;
    margin-top:60px;
}
html,
body{
    width:100%;
    overflow-x:hidden;
}

.container{
    width:100%;
    max-width:1320px;
}
    </style>

</head>

<body>
    @if(app()->getLocale() == 'ar')
<style>

body{
    direction:rtl;
    text-align:right;
}

.navbar{
    direction:rtl;
}

</style>
@endif
@unless(request()->routeIs('login') || request()->routeIs('register'))
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-0">
        <a class="nav-left navbar-brand d-flex align-items-center text-decoration-none" href="{{ LaravelLocalization::localizeUrl(route('home', [], false)) }}">
            <img src="{{ asset('images/logo.png') }}" class="brand-logo" alt="Logo">
            <div class="brand-text ms-2">
                <h1 class="mb-0 text-white" style="font-size: 24px;">Marrakech Tour</h1>
                <p class="mb-0" style="color: #F7DFA7; font-size: 11px;">Explore • Discover • Enjoy</p>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#marrakechNavbar" aria-controls="marrakechNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="marrakechNavbar">
            <div class="nav-right ms-auto d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-3 mt-3 mt-lg-0">
                <a href="{{ LaravelLocalization::localizeUrl(route('home', [], false)) }}"
                   class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    {{ __('navbar.home') }}
                </a>

                <a href="{{ LaravelLocalization::localizeUrl(route('attractions.index', [], false)) }}"
                   class="nav-link-custom {{ request()->routeIs('attractions.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ __('navbar.attractions') }}
                </a>

                @auth
                <a href="{{ route('profile.edit') }}"
                   class="nav-link-custom {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    {{ __('navbar.profile') }}
                </a>
                @endauth

                @guest
                <a href="{{ route('login') }}" class="nav-link-custom">
                    <i class="bi bi-box-arrow-in-right"></i>
                    {{ __('navbar.login') }}
                </a>
                @endguest

                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle w-100 text-start text-lg-center" type="button" data-bs-toggle="dropdown">
                        🌐 {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}">
                                🇫🇷 Français
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                🇬🇧 English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                🇲🇦 العربية
                            </a>
                        </li>
                    </ul>
                </div>

                @auth
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle w-100 text-start text-lg-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        @role('Admin')
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        @endrole
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> {{ __('navbar.profile') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('navbar.logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
@endunless
<main
@if(request()->routeIs('login') || request()->routeIs('register'))
class="d-flex justify-content-center align-items-center"
style="min-height:100vh;"
@endif
>

 @yield('content')

</main>

@unless(request()->routeIs('login') || request()->routeIs('register'))

<footer>

© {{ date('Y') }} Marrakech Tour

</footer>

@endunless

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.2/build/css/intlTelInput.css">
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.2/build/js/intlTelInput.min.js"></script>
<script>

const input = document.querySelector("#phone");

if(input){

    window.intlTelInput(input,{

        initialCountry:"auto",

        preferredCountries:["ma","fr","us"],

        separateDialCode:true,

        nationalMode:false,

        autoPlaceholder:"polite",

    });

}

function resizeCards(){

    const cards = document.querySelectorAll(".feature-card");

    cards.forEach(card=>{

        card.style.height="";

    });

    if(window.innerWidth >= 576){

        let max = 0;

        cards.forEach(card=>{

            if(card.offsetHeight > max){

                max = card.offsetHeight;

            }

        });

        cards.forEach(card=>{

            card.style.height = max + "px";

        });

    }

}

window.addEventListener("load", resizeCards);

window.addEventListener("resize", resizeCards);


</script>
</body>
</html>