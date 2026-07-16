@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')

<div class="container py-5">

  <div class="row justify-content-center">

  <div class="col-xl-9 col-lg-10">

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    {{ session('success') }}

    <button class="btn-close" data-bs-dismiss="alert"></button>

</div>

@endif

<div class="card border-0 shadow-lg rounded-5 overflow-hidden">

    <!-- Bannière -->

    <div class="profile-cover"></div>

    <div class="text-center">

        @if($user->photo)

            <img
                src="{{ asset('storage/'.$user->photo) }}"
                class="profile-photo shadow">

        @else

            <div class="profile-avatar shadow">

                {{ collect(explode(' ', $user->name))
                    ->map(fn($word)=>strtoupper(substr($word,0,1)))
                    ->take(2)
                    ->implode('') }}

            </div>

        @endif

        <h2 class="fw-bold mt-3">

            {{ $user->name }}

        </h2>

        <p class="text-muted">

            {{ __('profile.member_since') }}

            {{ $user->created_at->format('d/m/Y') }}

        </p>

        <span class="badge bg-primary rounded-pill px-4 py-2">

            <i class="bi bi-person-fill"></i>

            {{ __('profile.user') }}

        </span>

    </div>

<div class="card-body px-4 py-4">

        <!-- Cartes d'information -->

        <div class="row g-4 mb-5">

            <div class="col-md-4">

                <div class="info-box text-center">

                    <i class="bi bi-envelope-fill fs-2 text-warning"></i>

                    <h6 class="mt-3">

                        {{ __('profile.email') }}

                    </h6>

                    <small class="text-muted">

                        {{ $user->email }}

                    </small>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box text-center">

                    <i class="bi bi-calendar-event-fill fs-2 text-warning"></i>

                    <h6 class="mt-3">

                        {{ __('profile.registered') }}

                    </h6>

                    <small class="text-muted">

                        {{ $user->created_at->format('d/m/Y') }}

                    </small>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box text-center">

                    <i class="bi bi-clock-history fs-2 text-warning"></i>

                    <h6 class="mt-3">

                        {{ __('profile.login_history') }}

                    </h6>

                    <a
                        href="{{ route('login.history') }}"
                        class="btn btn-outline-warning btn-sm mt-2 rounded-pill">

                        {{ __('profile.view') }}

                    </a>

                </div>

            </div>

        </div>

        <!-- Suppression photo -->

        @if($user->photo)

        <form
            action="{{ route('profile.photo.delete') }}"
            method="POST"
            class="text-center mb-4"
            onsubmit="return confirm('{{ __('profile.confirm_delete_photo') }}');">

            @csrf
            @method('DELETE')

            <button class="btn btn-outline-danger rounded-pill">

                <i class="bi bi-trash-fill"></i>

                {{ __('profile.delete_photo') }}

            </button>

        </form>

        @endif

        <!-- Formulaire -->

        <form
            action="{{ route('profile.update') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PATCH')

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="fw-semibold">

                        {{ __('profile.fullname') }}

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$user->name) }}"
                        class="form-control rounded-4 @error('name') is-invalid @enderror">

                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                <div class="col-md-6 mb-4">

                    <label class="fw-semibold">

                        {{ __('profile.email') }}

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email',$user->email) }}"
                        class="form-control rounded-4 @error('email') is-invalid @enderror">

                    @error('email')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

            <div class="mb-4">

                <label class="fw-semibold">

                    {{ __('profile.photo') }}

                </label>

                <input
                    type="file"
                    name="photo"
                    class="form-control rounded-4 @error('photo') is-invalid @enderror">

                @error('photo')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <hr class="my-5">

            <h4 class="mb-4">

                🔒 {{ __('profile.change_password') }}

            </h4>

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label>

                        {{ __('profile.new_password') }}

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control rounded-4 @error('password') is-invalid @enderror">

                    @error('password')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                <div class="col-md-6 mb-4">

                    <label>

                        {{ __('profile.confirm_password') }}

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control rounded-4">

                </div>

            </div>

            <div class="text-center mt-4">

                <button class="btn btn-warning btn-lg rounded-pill px-5">

                    <i class="bi bi-check-circle-fill"></i>

                    {{ __('profile.save') }}

                </button>

            </div>

        </form>

    </div>

</div>

</div>

<style>

.profile-cover{

height:160px;

background:linear-gradient(135deg,#C96A2B,#8B4513);

}

.profile-photo{

width:170px;

height:170px;

object-fit:cover;

border-radius:50%;

margin-top:-90px;

border:6px solid white;

}

.profile-avatar{

width:170px;

height:170px;

border-radius:50%;

background:#C96A2B;

color:white;

display:flex;

justify-content:center;

align-items:center;

font-size:60px;

font-weight:bold;

margin:auto;

margin-top:-90px;

border:6px solid white;

}

.info-box{

background:#fff8f2;

padding:18px;

border-radius:20px;

transition:.35s;

height:100%;

}

.info-box:hover{

transform:translateY(-8px);

box-shadow:0 15px 35px rgba(0,0,0,.12);

}

.form-control{

padding:13px;

border-radius:15px;

}

.form-control:focus{

border-color:#C96A2B;

box-shadow:0 0 0 .25rem rgba(201,106,43,.20);

}

.btn-warning{

background:#C96A2B;

border:none;

}

.btn-warning:hover{

background:#8B4513;

}

</style>
</div>

</div>
@endsection