@extends('layouts.crud')

@section('content')

<div class="container py-5">

    <!-- En-tête -->
    <div class="text-center mb-5">

        <h1 class="fw-bold" style="color:#8B4513;">
            <i class="bi bi-pencil-square"></i>
            Modifier une attraction
        </h1>

        <p class="text-muted">
            Modifiez les informations de cette attraction touristique.
        </p>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header text-white py-3"
                     style="background:linear-gradient(90deg,#8B4513,#C96A2B);">

                    <h4 class="mb-0">

                        Informations de l'attraction

                    </h4>

                </div>

                <div class="card-body p-5">

                    <form action="{{ route('attractions.update',$attraction->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <!-- Nom -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                🏷️ Nom de l'attraction

                            </label>

                            <input
                                type="text"
                                name="attraction"
                                class="form-control form-control-lg"
                                value="{{ old('attraction',$attraction->attraction) }}">

                        </div>

                        <!-- Rating + Type -->

                        <div class="row">

                            <div class="col-md-4">

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        ⭐ Rating

                                    </label>

                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        max="5"
                                        name="rate"
                                        class="form-control form-control-lg"
                                        value="{{ old('rate',$attraction->rate) }}">

                                </div>

                            </div>

                            <div class="col-md-8">

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        🏛️ Type

                                    </label>

                                    <input
                                        type="text"
                                        name="type"
                                        class="form-control form-control-lg"
                                        value="{{ old('type',$attraction->type) }}">

                                </div>

                            </div>

                        </div>

                        <!-- Photo -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                📷 Photo

                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="photo"
                                name="photo"
                                accept="image/*">

                            <div class="mt-3 text-center">

                                @if($attraction->photo)

                                    <img
                                        id="preview"
                                        src="{{ asset('storage/'.$attraction->photo) }}"
                                        class="img-fluid rounded shadow"
                                        style="max-height:280px;">

                                @else

                                    <img
                                        id="preview"
                                        src="https://placehold.co/500x300?text=Aucune+Image"
                                        class="img-fluid rounded shadow"
                                        style="max-height:280px;">

                                @endif

                            </div>

                        </div>

                        <!-- Description -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                📝 Description

                            </label>

                            <textarea
                                name="details"
                                rows="5"
                                class="form-control">{{ old('details',$attraction->details) }}</textarea>

                        </div>

                        <!-- Latitude / Longitude -->

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        📍 Latitude

                                    </label>

                                    <input
                                        type="text"
                                        name="latitude"
                                        class="form-control"
                                        value="{{ old('latitude',$attraction->latitude) }}">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        📍 Longitude

                                    </label>

                                    <input
                                        type="text"
                                        name="longitude"
                                        class="form-control"
                                        value="{{ old('longitude',$attraction->longitude) }}">

                                </div>

                            </div>

                        </div>

                        <!-- Avis -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                💬 Avis

                            </label>

                            <textarea
                                name="reviews"
                                rows="5"
                                class="form-control">{{ old('reviews',$attraction->reviews) }}</textarea>

                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('attractions.index') }}"
                               class="btn btn-outline-secondary btn-lg">

                                <i class="bi bi-arrow-left"></i>

                                Retour

                            </a>

                            <button
                                class="btn btn-lg text-white"
                                style="background:#A0522D;">

                                <i class="bi bi-check-circle-fill"></i>

                                Enregistrer les modifications

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

document.getElementById('photo').addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(event){

            document.getElementById('preview').src = event.target.result;

        };

        reader.readAsDataURL(file);

    }

});

</script>

@endsection