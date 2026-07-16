@extends('layouts.crud')

@section('title', __('profile.title'))

@section('content')

<div class="container py-5">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

   <div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold" style="color:#8B4513;">

            <i class="bi bi-person-circle"></i>

            {{ __('profile.title') }}

        </h2>

        <p class="text-muted">

            {{ __('profile.subtitle') }}

        </p>

    </div>

    <a href="{{ route('login.history') }}"
       class="btn btn-outline-primary">

        <i class="bi bi-clock-history"></i>

        {{ __('profile.login_history') }}

    </a>

</div>

<div class="row">

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow rounded-4">

            <div class="card-body text-center p-5">

                <div class="text-center mb-4">

    @if($user->photo)

        <img
            src="{{ asset('storage/'.$user->photo) }}"
            class="rounded-circle shadow"
            width="140"
            height="140"
            style="object-fit:cover;">

    @else

        <div
            class="rounded-circle bg-warning text-dark d-flex justify-content-center align-items-center fw-bold mx-auto shadow"
            style="width:140px;height:140px;font-size:42px;">

            {{ collect(explode(' ', $user->name))
                ->map(fn($word)=>strtoupper(substr($word,0,1)))
                ->take(2)
                ->implode('') }}

        </div>

    @endif

</div>
@if($user->photo)

<form
    action="{{ route('profile.photo.delete') }}"
    method="POST"
    class="text-center mb-4"
    onsubmit="return confirm('{{ __('profile.confirm_delete_photo') }}');">

    @csrf
    @method('DELETE')

    <button class="btn btn-outline-danger btn-sm">

        <i class="bi bi-trash-fill"></i>

        {{ __('profile.delete_photo') }}

    </button>

</form>

@endif

                <h3 class="fw-bold mt-4">

                    {{ $user->name }}

                </h3>

               <span class="badge bg-danger fs-6 px-3 py-2">

    <i class="bi bi-shield-lock-fill"></i>

    {{ __('profile.admin') }}

</span>
                <hr>

                <div class="text-start">

                    <p class="mb-3">

                        <i class="bi bi-envelope-fill text-warning"></i>

                        <strong>{{ __('profile.email') }}</strong><br>

                        <span class="text-muted">

                            {{ $user->email }}

                        </span>

                    </p>

                    <p class="mb-3">

                        <i class="bi bi-calendar-event-fill text-warning"></i>

                        <strong>{{ __('profile.registered') }}</strong><br>

                        <span class="text-muted">

                            {{ $user->created_at->format('d/m/Y') }}

                        </span>

                    </p>

                    <p class="mb-0">

                        <i class="bi bi-clock-fill text-warning"></i>

                        <strong>{{ __('profile.time') }}</strong><br>

                        <span class="text-muted">

                            {{ $user->created_at->format('H:i') }}

                        </span>

                    </p>

                </div>

            </div>

        </div>

    </div>
    <div class="col-lg-8">

    <div class="card border-0 shadow rounded-4">

        <div class="card-header bg-white py-3">

            <h4 class="mb-0">

                <i class="bi bi-pencil-square text-warning"></i>

                     {{ __('profile.edit') }}            

            </h4>

        </div>

        <div class="card-body p-4">

           <form action="{{ route('profile.update') }}"method="POST"enctype="multipart/form-data">

                @csrf
                @method('PATCH')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            {{ __('profile.fullname') }}

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">

                        @error('name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            {{ __('profile.email') }}

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">

                        @error('email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>
                      <div class="mb-4">

    <label class="form-label fw-semibold">

        {{ __('profile.photo') }}

    </label>

    <input
        type="file"
        name="photo"
        class="form-control @error('photo') is-invalid @enderror">

    @error('photo')

        <div class="invalid-feedback">

            {{ $message }}

        </div>

    @enderror

</div>
                <hr class="my-4">

                <h5 class="mb-3">

                    <i class="bi bi-lock-fill text-warning"></i>

                    {{ __('profile.change_password') }}

                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            {{ __('profile.new_password') }}

                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror">

                        @error('password')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            {{ __('profile.confirm_password') }}

                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control">

                    </div>

                </div>

                <div class="text-end mt-4">

                    <button class="btn btn-warning px-4">

                        <i class="bi bi-check-circle-fill"></i>

                        {{ __('profile.save') }}

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</div>
</div>

<style>

.card{
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}

.form-control{
    border-radius:12px;
    padding:.7rem .9rem;
}

.form-control:focus{
    border-color:#C96A2B;
    box-shadow:0 0 0 .2rem rgba(201,106,43,.25);
}

.btn-warning{
    background:#C96A2B;
    border:none;
}

.btn-warning:hover{
    background:#A45A2A;
}

.badge{
    border-radius:30px;
}

</style>

@endsection