@extends('layouts.crud')
@push('styles')
<style>
    /* ── Gallery ─────────────────────────────────── */
    .gallery-wrap {
        position: relative;
        overflow: hidden;           /* clip, do NOT scroll behind sidebar */
        border-radius: 20px;
    }
    .gallery-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:42px;
    height:42px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.85);
    color:#8B4513;
    box-shadow:0 4px 15px rgba(0,0,0,.15);
    z-index:20;
    transition:.25s;
}

.gallery-arrow:hover{
    background:#C96A2B;
    color:white;
}

.gallery-prev{
    left:12px;
}

.gallery-next{
    right:12px;
}
    .image-scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        padding-bottom: 10px;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
    }
    .image-scroll-container::-webkit-scrollbar { height: 5px; }
    .image-scroll-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .image-scroll-container::-webkit-scrollbar-thumb { background: #C96A2B; border-radius: 10px; }

    .scroll-image {
        flex: 0 0 100%;
        height: 420px;
        object-fit: cover;
        border-radius: 20px;
        scroll-snap-align: start;
        display: block;
    }

    /* ── Dots ────────────────────────────────────── */
    .gallery-dots { display: flex; justify-content: center; gap: 8px; margin-top: 14px; }
    .gallery-dot  { width: 8px; height: 8px; border-radius: 50%; background: #d1c3b8; cursor: pointer; transition: background .3s, transform .3s; border: none; padding: 0; }
    .gallery-dot.active { background: #C96A2B; transform: scale(1.3); }

    /* ── Info Card ───────────────────────────────── */
    .info-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        padding: 1.75rem;
        position: sticky;
        top: 1.5rem;
        max-height: calc(100vh - 3rem);
        overflow-y: auto;
    }
    .info-card::-webkit-scrollbar { width: 4px; }
    .info-card::-webkit-scrollbar-thumb { background: #e0d0c0; border-radius: 10px; }

    /* ── Map ─────────────────────────────────────── */
    .map-container {
        width: 100%;
        height: 220px;
        border-radius: 14px;
        overflow: hidden;
        background: #eee;
    }

    /* ── Star Rating ─────────────────────────────── */
    .star-rating { display: flex; flex-direction: row-reverse; gap: 4px; }
    .star-rating input { display: none; }
    .star-rating label {
        font-size: 2rem;
        color: #d1c3b8;
        cursor: pointer;
        transition: color .2s, transform .15s;
        line-height: 1;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label { color: #f5a623; transform: scale(1.15); }

    /* ── Buttons ─────────────────────────────────── */
    .btn-gradient {
        background: linear-gradient(135deg, #C96A2B, #8B4513);
        color: #fff;
        border: none;
        transition: all .3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, #8B4513, #6b330e);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139,69,19,.25);
        color: #fff;
    }

    /* ── Reviews ─────────────────────────────────── */
    .review-card { border-radius: 14px; border: 1px solid #f0e8e0; background: #fefcfa; }
    .reply-card  { background: #f9f6f3; border-radius: 10px; }
</style>
@endpush
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
           <!-- Galerie Photos -->
<div class="col-lg-5">
      
    <div class="gallery-wrap mb-3" id="galleryWrap">
        <button
    class="gallery-arrow gallery-prev"
    id="prevBtn">

    <i class="bi bi-chevron-left"></i>

</button>

<button
    class="gallery-arrow gallery-next"
    id="nextBtn">

    <i class="bi bi-chevron-right"></i>

</button>


    <div class="image-scroll-container" id="imageScroll">

        @php
            $images = collect();

            // Ancienne photo en premier
            if ($attraction->photo) {
                $images->push((object)[
                    'image' => $attraction->photo,
                    'source' => 'legacy'
                ]);
            }

            // Puis toutes les autres images
            foreach ($attraction->images as $image) {
                $images->push($image);
            }

            // Suppression des doublons
            $images = $images->unique('image')->values();
        @endphp

        @forelse($images as $image)

            <img
                src="{{ asset('storage/'.$image->image) }}"
                class="scroll-image"
                alt="{{ $attraction->attraction }}">

        @empty

            <img
                src="https://placehold.co/900x420/F8F4EF/8B4513?text=No+Image"
                class="scroll-image">

        @endforelse

    </div>
 <div class="gallery-dots" id="galleryDots"></div>
</div>

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

                    @include('components.reviews')

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
{{-- Gallery dot navigation script --}}
<script>
(function() {
    const scroll = document.getElementById('imageScroll');
    const dotsWrap = document.getElementById('galleryDots');
    if (!scroll) return;

    const images = scroll.querySelectorAll('.scroll-image');
    let dots = [];

    images.forEach((_, i) => {
        const btn = document.createElement('button');
        btn.className = 'gallery-dot' + (i === 0 ? ' active' : '');
        btn.addEventListener('click', () => {
            scroll.scrollTo({ left: images[i].offsetLeft - scroll.offsetLeft, behavior: 'smooth' });
        });
        dotsWrap.appendChild(btn);
        dots.push(btn);
    });

    scroll.addEventListener('scroll', () => {
        const idx = Math.round(scroll.scrollLeft / scroll.offsetWidth);
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
    }, { passive: true });

    const prev = document.getElementById('prevBtn');
const next = document.getElementById('nextBtn');

prev.addEventListener('click', () => {

    scroll.scrollBy({

        left: -scroll.offsetWidth,

        behavior: 'smooth'

    });

});

next.addEventListener('click', () => {

    scroll.scrollBy({

        left: scroll.offsetWidth,

        behavior: 'smooth'

    });

});
})();
</script>

@endsection
