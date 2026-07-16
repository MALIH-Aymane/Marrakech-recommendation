@extends('layouts.crud')

@section('content')

<div class="container py-5">

    <!-- Titre -->
    <div class="text-center mb-5">

        <h1 class="fw-bold" style="color:#8B4513;">
            <i class="bi bi-geo-alt-fill"></i>
            {{ $attraction->attraction }}
        </h1>

        <p class="text-muted">
            {{ __('attractions.show_subtitle') }}
        </p>

    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <div class="row g-0">

            <!-- Photo -->
            <div class="col-lg-5">

                @if($attraction->photo)

                    <img src="{{ asset('storage/'.$attraction->photo) }}"
                         class="img-fluid w-100 h-100"
                         style="object-fit:cover; min-height:500px;">

                @else

                    <img src="https://placehold.co/700x500/F8F4EF/8B4513?text=Aucune+Image"
                         class="img-fluid w-100 h-100"
                         style="object-fit:cover; min-height:500px;">

                @endif

            </div>

            <!-- Informations -->
            <div class="col-lg-7">

                <div class="p-5">

                    <!-- Rating + Type -->

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#A0522D;font-size:15px;">

                            ⭐ {{ number_format($attraction->rate,1) }}/5

                        </span>

                        <span class="badge rounded-pill px-3 py-2 bg-warning text-dark"
                              style="font-size:15px;">

                           🏛️ {{ __('attractions.types.'.$attraction->type) }}

                        </span>

                    </div>

                    <!-- Nom -->

                    <h2 class="fw-bold mb-4">

                        {{ $attraction->attraction }}

                    </h2>

                    <hr>

                    <!-- Description -->

                    <h5 style="color:#8B4513;">

                        <i class="bi bi-info-circle-fill"></i>

                        {{ __('attractions.description') }}

                    </h5>

                    <p class="text-muted">

                        {{ $attraction->details }}

                    </p>

                    <hr>

                    <!-- Coordonnées -->

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <div class="card border-0 bg-light shadow-sm">

                                <div class="card-body">

                                    <strong>

                                        📍 {{ __('attractions.latitude') }}

                                    </strong>

                                    <br>

                                    {{ $attraction->latitude ?? __('attractions.not_available') }}

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="card border-0 bg-light shadow-sm">

                                <div class="card-body">

                                    <strong>

                                        📍 {{ __('attractions.longitude') }}

                                    </strong>

                                    <br>

                                    {{ $attraction->longitude ?? __('attractions.not_available') }}

                                </div>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <!-- Avis -->

                    <h5 style="color:#8B4513;">

                        <i class="bi bi-chat-left-text-fill"></i>

                        {{ __('attractions.reviews') }}

                    </h5>

                    <div class="bg-light rounded-3 p-3">

                        {{ $attraction->reviews }}

                    </div>

                    <!-- Boutons -->

                    <div class="mt-5 d-flex justify-content-between">

                        <a href="{{ route('attractions.index') }}"
                           class="btn btn-outline-secondary btn-lg">

                            <i class="bi bi-arrow-left"></i>

                           {{ __('attractions.back') }}

                        </a>

                        @role('Admin')
<a href="{{ route('attractions.edit',$attraction->id) }}"
   class="btn text-white btn-lg"
   style="background:#A0522D;">

    <i class="bi bi-pencil-square"></i>

    {{ __('attractions.edit') }}

</a>
@endrole

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection