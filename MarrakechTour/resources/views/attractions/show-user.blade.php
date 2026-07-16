@extends('layouts.app')

@section('title',$attraction->attraction)

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold" style="color:#8B4513;">

            <i class="bi bi-geo-alt-fill"></i>

            {{ $attraction->attraction }}

        </h1>

        <p class="text-muted">

            {{ __('attractions.show_subtitle') }}

        </p>

    </div>


    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">

        <div class="row g-0">

            <div class="col-lg-6">

                @if($attraction->photo)

                    <img
                        src="{{ asset('storage/'.$attraction->photo) }}"
                        class="w-100 h-100 attraction-photo">

                @endif

            </div>


            <div class="col-lg-6">

                <div class="p-5">

                    <div class="d-flex flex-wrap gap-3 mb-4">

                        <span class="badge rounded-pill bg-warning text-dark px-4 py-3">

                            ⭐ {{ number_format($attraction->rate,1) }}/5

                        </span>

                        <span class="badge rounded-pill bg-dark px-4 py-3">

                            {{ __('attractions.types.'.$attraction->type) }}

                        </span>

                    </div>


                    <h2 class="fw-bold mb-4">

                        {{ $attraction->attraction }}

                    </h2>


                    <div class="card border-0 bg-light rounded-4 mb-4">

                        <div class="card-body">

                            <h5>

                                <i class="bi bi-chat-left-text-fill text-warning"></i>

                                {{ __('attractions.reviews') }}

                            </h5>

                            <p class="text-muted mb-0">

                                {{ $attraction->reviews ?: __('attractions.not_available') }}

                            </p>

                        </div>

                    </div>


                    @if($attraction->attraction_url)

                        <a
                            href="{{ $attraction->attraction_url }}"
                            target="_blank"
                            class="btn btn-warning w-100 rounded-pill py-3 mb-3">

                            <i class="bi bi-globe2"></i>

                            {{ __('attractions.visit_site') }}

                        </a>

                    @endif


                    @if($attraction->reviews_url)

                        <a
                            href="{{ $attraction->reviews_url }}"
                            target="_blank"
                            class="btn btn-outline-warning w-100 rounded-pill py-3">

                            <i class="bi bi-star-fill"></i>

                            {{ __('attractions.read_reviews') }}

                        </a>

                    @endif


                    <div class="text-center mt-5">

                        <a
                            href="{{ route('attractions.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-5">

                            <i class="bi bi-arrow-left"></i>

                            {{ __('attractions.back') }}

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.attraction-photo{

    min-height:650px;
    object-fit:cover;
    transition:.5s;

}

.attraction-photo:hover{

    transform:scale(1.03);

}

.card{

    border-radius:25px;

}

.btn-warning{

    background:#C96A2B;
    border:none;

}

.btn-warning:hover{

    background:#8B4513;

}

.badge{

    font-size:15px;

}

</style>

@endsection