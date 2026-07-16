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
    background:#A45A2A;
    display:flex;
    justify-content:space-between;
    align-items:center;
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
}

.nav-link-custom:hover{
    color:white;
    background:rgba(255,255,255,.15);
}

.nav-link-custom.active{
    background:white;
    color:#A45A2A;
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
<nav class="navbar">

<div class="nav-left">

<img src="{{ asset('images/logo.png') }}" class="brand-logo">

<div class="brand-text">
<h1>Marrakech Tour</h1>
<p>Explore • Discover • Enjoy</p>
</div>

</div>

<div class="nav-right">

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

    <button
        class="btn btn-outline-light btn-sm dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown">

        🌐 {{ strtoupper(app()->getLocale()) }}

    </button>

    <ul class="dropdown-menu dropdown-menu-end">

        <li>
            <a class="dropdown-item"
               href="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}">
                🇫🇷 Français
            </a>
        </li>

        <li>
            <a class="dropdown-item"
               href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                🇬🇧 English
            </a>
        </li>

        <li>
            <a class="dropdown-item"
               href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                🇲🇦 العربية
            </a>
        </li>

    </ul>

</div>
   @auth

<div class="dropdown">

    <button
        class="btn btn-outline-light dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown">

        <i class="bi bi-person-circle"></i>

        {{ auth()->user()->name }}

    </button>

    <ul class="dropdown-menu dropdown-menu-end">

        @role('Admin')

        <li>

            <a class="dropdown-item"
               href="{{ route('dashboard') }}">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        @endrole

        <li>

            <a class="dropdown-item"
               href="{{ route('profile.edit') }}">

                <i class="bi bi-person"></i>

                {{ __('navbar.profile') }}

            </a>

        </li>

        <li><hr class="dropdown-divider"></li>

        <li>

            <form action="{{ route('logout') }}"
                  method="POST">

                @csrf

                <button
                    class="dropdown-item">

                    <i class="bi bi-box-arrow-right"></i>

                    {{ __('navbar.logout') }}

                </button>

            </form>

        </li>

    </ul>

</div>

@endauth

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

</script>
</body>
</html>