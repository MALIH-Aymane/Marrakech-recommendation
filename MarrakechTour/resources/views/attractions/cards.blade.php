@extends('layouts.app')

@section('title', __('navbar.attractions'))

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold" style="color:#8B4513;">
            {{ __('attractions.title') }}
        </h2>

        <p class="text-muted">
            {{ __('attractions.subtitle') }}
        </p>

    </div>

    <div class="row g-4">

        @forelse($attractions as $attraction)

            <div class="col-lg-4 col-md-6">

                <div class="card border-0 shadow feature-card h-100">

                    @if($attraction->photo)

                        <img
                            src="{{ asset('storage/'.$attraction->photo) }}"
                            class="card-img-top"
                            style="height:240px;object-fit:cover;">

                    @else

                        <img
                            src="https://placehold.co/600x400?text=No+Image"
                            class="card-img-top"
                            style="height:240px;object-fit:cover;">

                    @endif

                    <div class="card-body d-flex flex-column">

                        <h4 class="fw-bold">

                            {{ $attraction->attraction }}

                        </h4>

                        <div class="mb-3">

    <span class="badge bg-warning text-dark">
        {{ __('attractions.types.' . $attraction->type, [], app()->getLocale()) }}
    </span>

    <span class="ms-2 text-muted">
        ⭐ {{ number_format($attraction->rate,1) }}/5
    </span>

    @php
        $details = trim(strip_tags($attraction->details));
    @endphp

    @if($details && \Illuminate\Support\Str::length($details) <= 15)
        <span class="ms-2 text-muted">
            {{ $details }}
        </span>
    @endif

</div>

                        @php
    $details = trim(strip_tags($attraction->details));
@endphp

@if($details && \Illuminate\Support\Str::length($details) > 15)

    <p class="text-muted flex-grow-1 mb-3">

        {{ \Illuminate\Support\Str::limit($details,120) }}

    </p>

@else

    <div class="flex-grow-1"></div>

@endif

                        <a
                            href="{{ route('attractions.show',$attraction->id) }}"
                            class="btn btn-warning rounded-pill">

                            <i class="bi bi-eye-fill"></i>

                            {{ __('attractions.details') }}

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info text-center">

                    {{ __('attractions.not_available') }}

                </div>

            </div>

        @endforelse

    </div>

</div>

<style>

.feature-card{

    transition:.35s;
    border-radius:20px;

}

.feature-card:hover{

    transform:translateY(-8px);
    box-shadow:0 18px 35px rgba(0,0,0,.18);

}

.feature-card img{

    transition:.5s;

}

.feature-card:hover img{

    transform:scale(1.05);

}

.btn-warning{

    background:#C96A2B;
    border:none;

}

.btn-warning:hover{

    background:#8B4513;

}

</style>

@endsection
