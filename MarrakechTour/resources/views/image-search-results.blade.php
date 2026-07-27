@extends('layouts.app')

@section('title','Image Search Results')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold" style="color:#8B4513;">

            <i class="bi bi-camera-fill"></i>

            AI Image Search Results

        </h2>

        <p class="text-muted">

            The attractions below are the most visually similar to your uploaded image.

        </p>

        <a href="{{ url('/') }}" class="btn btn-warning rounded-pill">

            <i class="bi bi-arrow-left"></i>

            New Search

        </a>

    </div>


    <div class="row g-4">

        @forelse($results as $attraction)

        <div class="col-lg-4 col-md-6">

            <div class="card h-100 shadow border-0 rounded-4">

                @php
                    $image = $attraction->images->first();
                @endphp

                @if($image)

                    <img
                        src="{{ asset('storage/'.$image->image) }}"
                        class="card-img-top"
                        style="height:250px;object-fit:cover;">

                @else

                    <img
                        src="https://placehold.co/600x350?text=No+Image"
                        class="card-img-top"
                        style="height:250px;object-fit:cover;">

                @endif


                <div class="card-body">

                    <h4 class="fw-bold">

                        {{ $attraction->attraction }}

                    </h4>


                    <div class="mb-3">

                        <span
                            class="badge bg-success fs-6">

                            Similarity :

                            {{ number_format($attraction->similarity*100,2) }} %

                        </span>

                    </div>


                    <p class="text-muted">

                        {{ Str::limit($attraction->description,120) }}

                    </p>


                    <a
                        href="{{ route('attractions.show',$attraction->id) }}"
                        class="btn btn-outline-warning rounded-pill">

                        View Details

                    </a>

                </div>

            </div>

        </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning text-center">

                    No similar attractions found.

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection