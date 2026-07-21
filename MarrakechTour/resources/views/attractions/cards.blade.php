@extends('layouts.app')

@section('title', __('navbar.attractions'))

@section('content')

<div class="container py-5">

  <div class="attractions-header mb-5">

    <div class="header-text">

        <h2 class="fw-bold mb-2" style="color:#8B4513;">
            {{ __('attractions.title') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('attractions.subtitle') }}
        </p>

    </div>

    <a href="{{ route('find.attraction') }}"
       class="btn btn-find rounded-pill px-4 py-3">

        <i class="bi bi-stars me-2"></i>

        {{ __('find_attraction.title') }}

    </a>

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

   <div class="pagination-wrapper">
    {{ $attractions->links() }}
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

.pagination-wrapper nav{
    display:flex;
    justify-content:center;
}

.pagination{
    gap:10px;
    margin:0;
}

.pagination .page-item .page-link{
    border:none;
    border-radius:12px;
    min-width:45px;
    height:45px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff;
    color:#8B4513;
    font-weight:600;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    transition:.3s;
}

.pagination .page-item .page-link:hover{
    background:#C96A2B;
    color:#fff;
    transform:translateY(-2px);
}

.pagination .page-item.active .page-link{
    background:#8B4513;
    color:#fff;
    box-shadow:0 6px 16px rgba(139,69,19,.35);
}

.pagination .page-item.disabled .page-link{
    background:#f3f3f3;
    color:#aaa;
    box-shadow:none;
}

@media (max-width:768px){

    .pagination{
        flex-wrap:wrap;
        justify-content:center;
    }

    .pagination .page-link{
        min-width:38px;
        height:38px;
        font-size:.9rem;
    }

}

.btn-find{

    background:linear-gradient(135deg,#C96A2B,#8B4513);
    color:white;
    border:none;
    font-weight:600;
    transition:.35s;
    box-shadow:0 8px 22px rgba(139,69,19,.25);

}

.btn-find:hover{

    color:white;
    transform:translateY(-4px);
    box-shadow:0 14px 30px rgba(139,69,19,.35);

}

.btn-find i{

    font-size:1.1rem;

}
@media (max-width:768px){

    .d-flex.justify-content-between{

        text-align:center;
        justify-content:center !important;

    }

    .btn-find{

        width:100%;

    }

}
.attractions-header{

    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:3rem;

}

.header-text{

    text-align:center;

    transform:translateX(-80px);

}

.btn-find{

    position:absolute;
    right:0;

    background:linear-gradient(135deg,#C96A2B,#8B4513);
    color:white;
    border:none;
    font-weight:600;
    border-radius:50px;
    transition:.35s;
    box-shadow:0 8px 22px rgba(139,69,19,.25);

}

.btn-find:hover{

    color:white;
    transform:translateY(-3px);
    box-shadow:0 14px 30px rgba(139,69,19,.35);

}

@media (max-width:992px){

    .attractions-header{

        flex-direction:column;

    }

    .header-text{

        transform:none;
        margin-bottom:20px;

    }

    .btn-find{

        position:static;

    }

}
</style>

@endsection
