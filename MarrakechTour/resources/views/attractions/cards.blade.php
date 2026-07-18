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

            <div class="col-12 col-sm-6 col-lg-4 d-flex">

                <div class="card border-0 shadow feature-card h-100 w-100">

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

                        <h4 class="fw-bold attraction-title">

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

   <p class="text-muted attraction-description flex-grow-1 mb-3">

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

    border-radius:20px;
    transition:.35s;
    overflow:hidden;
}

.feature-card:hover{

    transform:translateY(-8px);
    box-shadow:0 18px 35px rgba(0,0,0,.18);

}

.feature-card img{

    height:240px;
    object-fit:cover;
    transition:.5s;

}

.feature-card:hover img{

    transform:scale(1.05);

}

.attraction-title{

    min-height:65px;
    display:flex;
    align-items:center;
    font-size:1.65rem;
    line-height:1.3;

}

.attraction-description{

    min-height:55px;
    font-size:.95rem;

}

.btn-warning{

    background:#C96A2B;
    border:none;

}

.btn-warning:hover{

    background:#8B4513;

}

/* ---------- Responsive ---------- */

@media (max-width:992px){

    .feature-card img{

        height:220px;

    }

}

@media (max-width:768px){

    .feature-card img{

        height:210px;

    }

    .attraction-title{

        min-height:auto;
        font-size:1.45rem;

    }

    .attraction-description{

        min-height:auto;

    }

}

@media (max-width:576px){

    .feature-card{

        border-radius:18px;

    }

    .feature-card img{

        height:200px;

    }

    .btn{

        font-size:.95rem;

    }

}

</style>

@endsection
