@extends('layouts.app')

@section('title', __('register.title'))

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow rounded-4">

                <div class="card-body p-4">

                   <div class="text-center mb-4">

    <img src="{{ asset('images/logo.png') }}"
         width="85"
         class="mb-3">

    <h2 class="fw-bold">

        {{ __('register.welcome') }}

    </h2>

    <p class="text-muted">

        {{ __('register.subtitle') }}

    </p>

</div>

                    <form method="POST" action="{{ route('register') }}">

                        @csrf

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
            required>

    </div>

</div>

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
            required>

    </div>

</div>

<div class="mb-3">

    <label class="form-label">

        {{ __('register.phone') }}

    </label>

    <input
        id="phone"
        type="tel"
        name="phone"
        class="form-control">

</div>

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

                        <button class="btn btn-warning w-100 rounded-pill py-2">

                            {{ __('register.register') }}

                        </button>

                    </form>

                    <div class="text-center my-4">

    <span class="text-muted">

        {{ __('register.or') }}

    </span>

</div>

<a href="{{ route('login') }}"
   class="btn btn-outline-warning w-100 rounded-pill">

    <i class="bi bi-box-arrow-in-right"></i>

    {{ __('register.login') }}

</a>
                </div>

            </div>

        </div>

    </div>

</div>
<style>

.card{
    border:none;
}

.input-group-text{
    background:white;
}

.form-control{
    border-left:none;
}

.form-control:focus{
    border-color:#C96A2B;
    box-shadow:none;
}

.input-group:focus-within .input-group-text{
    border-color:#C96A2B;
}

.btn-warning{
    background:#C96A2B;
    border:none;
}

.btn-warning:hover{
    background:#8B4513;
}

.btn-outline-warning{
    border-color:#C96A2B;
    color:#C96A2B;
}

.btn-outline-warning:hover{
    background:#C96A2B;
    color:white;
}

</style>
@endsection