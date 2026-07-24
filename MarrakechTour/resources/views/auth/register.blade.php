@extends('layouts.app')

@section('title', __('register.title'))

@section('content')

<div class="container-fluid px-0 h-100">
    <div class="row g-0 min-vh-100">
        <!-- Brand/Hero Column (left) -->
        <div class="col-lg-6 d-none d-lg-block position-relative hero-column">
            <div class="hero-overlay"></div>
            <div class="hero-content d-flex flex-column justify-content-between h-100 p-5 text-white">
                <div>
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-white text-decoration-none">
                        <img src="{{ asset('images/logo.png') }}" width="45" class="brand-logo-img" alt="Logo">
                        <span class="ms-2 fw-bold fs-4">Marrakech Tour</span>
                    </a>
                </div>
                <div class="mb-5">
                    <h1 class="display-4 fw-bold mb-3" style="font-family: 'Poppins', sans-serif; line-height: 1.2;">
                        {{ __('login.hero_title') }}
                    </h1>
                    <p class="lead text-amber-light opacity-90" style="font-size: 1.15rem; font-weight: 300;">
                        {{ __('login.hero_subtitle') }}
                    </p>
                </div>
                <div class="small opacity-75">
                    © {{ date('Y') }} Marrakech Tour. {{ __('login.rights') }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 d-flex align-items-center justify-content-center py-5 form-column bg-light-warm position-relative">
            <!-- Language Switcher -->
            <div class="position-absolute top-0 end-0 p-4">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown" style="border-color: rgba(164, 90, 42, 0.2); color: #4a2711; background: transparent;">
                        🌐 {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" style="min-width: 120px;">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="dropdown-item py-2 {{ app()->getLocale() == $localeCode ? 'active' : '' }}" 
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                   style="{{ app()->getLocale() == $localeCode ? 'background-color: #A45A2A; color: white;' : 'color: #4a2711;' }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-wrapper">
                <div class="card login-card shadow border-0 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}"
                             width="80"
                             class="mb-3 d-lg-none brand-logo-img"
                             alt="Marrakech Tour">
                        <h2 class="fw-bold" style="color: #4a2711; letter-spacing: -0.5px;">
                            {{ __('register.welcome') }}
                        </h2>
                        <p class="text-muted small">
                            {{ __('register.subtitle') }}
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 py-2 border-0 small text-center mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('register.name') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="{{ __('register.name') }}"
                                    value="{{ old('name') }}"
                                    required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('register.email') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="{{ __('register.email') }}"
                                    value="{{ old('email') }}"
                                    required>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('register.phone') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>
                                <input
                                    id="phone"
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('register.password') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="{{ __('register.password') }}"
                                    required>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label">
                                {{ __('register.password_confirmation') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="{{ __('register.password_confirmation') }}"
                                    required>
                            </div>
                        </div>

                        <button class="btn btn-premium-primary w-100 py-3 mb-3">
                            <i class="bi bi-person-plus-fill"></i>
                            {{ __('register.register') }}
                        </button>
                    </form>

                    <div class="divider">
                        <span>{{ __('register.or') }}</span>
                    </div>

                    <a href="{{ route('login') }}"
                       class="btn btn-premium-secondary w-100 py-3">
                        <i class="bi bi-box-arrow-in-right"></i>
                        {{ __('register.login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Override main container layout for register page */
main {
    display: block !important;
    padding: 0 !important;
    min-height: 100vh !important;
    width: 100% !important;
}

body {
    background: #fdfbf7 !important;
}

.form-wrapper {
    width: 100%;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    max-width: 480px; /* default for mobile */
}

@media (min-width: 576px) {
    .form-wrapper {
        max-width: 520px;
    }
}

@media (min-width: 992px) {
    .form-wrapper {
        max-width: 560px;
    }
}

@media (min-width: 1200px) {
    .form-wrapper {
        max-width: 600px;
    }
}

@media (min-width: 1400px) {
    .form-wrapper {
        max-width: 650px;
    }
}

/* Hero column styling */
.hero-column {
    background-image: url("{{ asset('images/jemaa-elfnaa-at-night.webp') }}");
    background-size: cover;
    background-position: center;
    min-height: 100vh;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(43, 17, 4, 0.85) 0%, rgba(164, 90, 42, 0.65) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

/* Form column styling */
.bg-light-warm {
    background-color: #fdfbf7;
    min-height: 100vh;
}

.login-card {
    background: white !important;
    border-radius: 20px !important;
    box-shadow: 0 10px 30px rgba(164, 90, 42, 0.08) !important;
    border: none !important;
}

.brand-logo-img {
    transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.brand-logo-img:hover {
    transform: rotate(10deg) scale(1.1);
}

.form-label {
    font-weight: 600;
    color: #4a2711;
    font-size: 0.95rem;
    margin-bottom: 8px;
}

.input-group {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(164, 90, 42, 0.04);
    border: 1.5px solid rgba(164, 90, 42, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.input-group:focus-within {
    border-color: #A45A2A;
    box-shadow: 0 0 0 0.25rem rgba(164, 90, 42, 0.15);
    transform: translateY(-1px);
}

.input-group-text {
    background: transparent;
    border: none;
    color: #A45A2A;
    padding-left: 20px;
    padding-right: 10px;
    font-size: 1.25rem;
}

.form-control {
    border: none;
    padding: 14px 18px;
    font-size: 1.05rem;
    background: transparent;
}

.form-control:focus {
    box-shadow: none;
    background: transparent;
}

/* Specific formatting for international telephone input */
.iti {
    width: 100%;
}
.iti__country-list {
    z-index: 10;
}

.btn-premium-primary {
    background: linear-gradient(135deg, #A45A2A 0%, #8B4513 100%);
    color: white;
    border: none;
    font-weight: 600;
    padding: 14px 20px;
    font-size: 1.05rem;
    border-radius: 30px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 10px rgba(164, 90, 42, 0.2);
}

.btn-premium-primary:hover {
    background: linear-gradient(135deg, #c36c34 0%, #A45A2A 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(164, 90, 42, 0.4);
}

.btn-premium-secondary {
    background: transparent;
    border: 2px solid #A45A2A;
    color: #A45A2A;
    font-weight: 600;
    padding: 13px 20px;
    font-size: 1.05rem;
    border-radius: 30px;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.btn-premium-secondary:hover {
    background: #A45A2A;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(164, 90, 42, 0.2);
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: rgba(164, 90, 42, 0.4);
    margin: 20px 0;
    font-size: 0.9rem;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid rgba(164, 90, 42, 0.12);
}

.divider:not(:empty)::before {
    margin-right: .8em;
}

.divider:not(:empty)::after {
    margin-left: .8em;
}

.text-amber-light {
    color: #ffd8a8;
}

/* Responsive Tweak */
@media (max-width: 991.98px) {
    .bg-light-warm {
        background: linear-gradient(135deg, #2b1104 0%, #A45A2A 50%, #e07d4f 100%) !important;
    }
    .login-card {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
    }
}
</style>
@endsection