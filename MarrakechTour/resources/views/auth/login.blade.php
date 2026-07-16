@extends('layouts.app')

@section('title', __('login.title'))

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow rounded-4">

                <div class="card-body p-4">

                   <div class="text-center mb-4">

    <img src="{{ asset('images/logo.png') }}"
         width="85"
         class="mb-3">

    <h2 class="fw-bold">

        {{ __('login.welcome') }}

    </h2>

    <p class="text-muted">

        {{ __('login.subtitle') }}

    </p>

</div>
                    @if ($errors->any())

    <div class="alert alert-danger">

        {{ $errors->first() }}

    </div>

@endif

                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <div class="mb-3">

    <label class="form-label">

        {{ __('login.email') }}

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-envelope-fill"></i>

        </span>

        <input
            type="email"
            name="email"
            class="form-control"
            placeholder="{{ __('login.email') }}"
            required>

    </div>

</div>
                        <div class="mb-4">

    <label class="form-label">

        {{ __('login.password') }}

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-lock-fill"></i>

        </span>

        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="{{ __('login.password') }}"
            required>

    </div>

</div>

                        <button class="btn btn-warning w-100 rounded-pill py-2">

    <i class="bi bi-box-arrow-in-right"></i>

    {{ __('login.login') }}

</button>

                    </form>

                    <div class="text-center my-4">

    <span class="text-muted">

        {{ __('login.or') }}

    </span>

</div>

<a href="{{ route('register') }}"
   class="btn btn-outline-warning w-100 rounded-pill">

    <i class="bi bi-person-plus-fill"></i>

    {{ __('login.create_account') }}

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
    box-shadow:none;
    border-color:#C96A2B;
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