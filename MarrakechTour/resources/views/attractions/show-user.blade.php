@extends('layouts.app')

@section('title', $attraction->attraction)

@push('styles')
<style>
    /* ── Gallery ─────────────────────────────────── */
    .gallery-wrap {
        position: relative;
        overflow: hidden;           /* clip, do NOT scroll behind sidebar */
        border-radius: 20px;
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
<div class="container py-4">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <a href="{{ route('attractions.index') }}" class="btn btn-sm btn-light rounded-pill text-muted fw-medium px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <span class="badge rounded-pill px-3 py-2 text-dark" style="background:#ffc107;font-size:.85rem;">
            ⭐ {{ number_format($attraction->rate, 1) }}/5
        </span>
        <span class="badge rounded-pill bg-dark text-white px-3 py-2" style="font-size:.85rem;">
            🏛️ {{ __('attractions.types.'.$attraction->type) }}
        </span>
    </div>

    <h1 class="fw-bolder mb-1" style="color:#2c1e16;font-size:clamp(1.8rem,4vw,2.6rem);">
        {{ $attraction->attraction }}
    </h1>
    <p class="text-muted mb-4">
        <i class="bi bi-geo-alt-fill text-warning me-1"></i>Marrakech, Morocco
        &nbsp;·&nbsp;
        <i class="bi bi-chat-dots-fill text-warning me-1"></i>{{ $attraction->reviews_count ?? 0 }} reviews
    </p>

    {{-- ── Two-column Grid ──────────────────────────── --}}
    <div class="row g-4 align-items-start">

        {{-- Left: Gallery + Reviews --}}
        <div class="col-lg-7">

            {{-- Gallery --}}
            <div class="gallery-wrap mb-3" id="galleryWrap">
                <div class="image-scroll-container" id="imageScroll">
                    @if($attraction->photo)
                        <img src="{{ asset('storage/'.$attraction->photo) }}" class="scroll-image" alt="{{ $attraction->attraction }}">
                    @else
                        <img src="https://placehold.co/900x420/F8F4EF/8B4513?text=No+Image" class="scroll-image" alt="No image">
                    @endif
                    <img src="https://placehold.co/900x420/EDE0D4/A0522D?text=View+2" class="scroll-image" alt="View 2">
                    <img src="https://placehold.co/900x420/DDD0C4/8B4513?text=View+3" class="scroll-image" alt="View 3">
                </div>
                <div class="gallery-dots" id="galleryDots"></div>
            </div>

            {{-- Reviews --}}
            <div class="bg-white p-4 rounded-4 shadow-sm border mt-4">
                @include('components.reviews')
            </div>

        </div>

        {{-- Right: Info Card --}}
        <div class="col-lg-5">
            <div class="info-card">

                <h5 class="fw-bold mb-3" style="color:#8B4513;">
                    <i class="bi bi-info-circle-fill text-warning me-2"></i>About
                </h5>

                @if($attraction->details)
                    <p class="fw-semibold text-dark mb-2" style="font-size:.9rem;">
                        {{ $attraction->details }}
                    </p>
                @endif

                <p class="text-muted mb-4" style="font-size:.88rem;line-height:1.75;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>

                <div class="d-flex flex-column gap-2 mb-4">
                    @if($attraction->attraction_url)
                        <a href="{{ $attraction->attraction_url }}" target="_blank"
                           class="btn btn-gradient rounded-pill py-2 fw-semibold">
                            <i class="bi bi-globe2 me-2"></i>{{ __('attractions.visit_site') }}
                        </a>
                    @endif
                    @if($attraction->reviews_url)
                        <a href="{{ $attraction->reviews_url }}" target="_blank"
                           class="btn btn-outline-secondary rounded-pill py-2 fw-semibold">
                            <i class="bi bi-star-fill me-2"></i>{{ __('attractions.read_reviews') }}
                        </a>
                    @endif
                </div>

                {{-- Map --}}
                <h6 class="fw-bold mb-2" style="color:#8B4513;">
                    <i class="bi bi-map-fill text-warning me-2"></i>Location
                </h6>
                <div class="map-container shadow-sm">
                    @if($attraction->latitude && $attraction->longitude)
                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                            src="https://maps.google.com/maps?q={{ $attraction->latitude }},{{ $attraction->longitude }}&hl=en&z=15&output=embed"
                            allowfullscreen loading="lazy">
                        </iframe>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                            <div class="text-center">
                                <i class="bi bi-map fs-1"></i>
                                <p class="mt-2 small fw-medium mb-0">Location not available</p>
                            </div>
                        </div>
                    @endif
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
})();
</script>
@endsection