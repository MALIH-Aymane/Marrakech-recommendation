@extends('layouts.app')

@section('title', __('find_attraction.title'))

@section('content')

<div class="container py-5">

    {{-- ========================================= --}}
    {{-- HERO --}}
    {{-- ========================================= --}}

    <div class="text-center mb-5">

        <h1 class="display-4 fw-bold text-brown">

            ✨ {{ __('find_attraction.title') }}

        </h1>

        <p class="lead text-muted">

            {{ __('find_attraction.subtitle') }}

        </p>

    </div>


    {{-- ========================================= --}}
    {{-- SUGGESTIONS --}}
    {{-- ========================================= --}}

    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">

        <span
            class="badge rounded-pill suggestion-chip clickable-chip"
            data-prompt="{{ __('find_attraction.garden') }}">

            🌿 {{ __('find_attraction.garden') }}

        </span>

        <span
            class="badge rounded-pill suggestion-chip clickable-chip"
            data-prompt="{{ __('find_attraction.history') }}">

            🕌 {{ __('find_attraction.history') }}

        </span>

        <span
            class="badge rounded-pill suggestion-chip clickable-chip"
            data-prompt="{{ __('find_attraction.museum') }}">

            🎨 {{ __('find_attraction.museum') }}

        </span>

        <span
            class="badge rounded-pill suggestion-chip clickable-chip"
            data-prompt="{{ __('find_attraction.relax') }}">

            ☕ {{ __('find_attraction.relax') }}

        </span>

        <span
            class="badge rounded-pill suggestion-chip clickable-chip"
            data-prompt="{{ __('find_attraction.sunset') }}">

            🌅 {{ __('find_attraction.sunset') }}

        </span>

    </div>


    {{-- ========================================= --}}
    {{-- SEARCH CARD --}}
    {{-- ========================================= --}}

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="search-card">

                <div class="search-header">

                    <h3>

                        🔍 AI Tourist Search

                    </h3>

                    <p>

                        Search by description, image or combine both for better recommendations.

                    </p>

                </div>


                <form
                    id="findForm"
                    action="{{ route('find.attraction') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    <div class="search-box">

                        {{-- Upload image --}}

                        <label
                            class="image-button"
                            for="imageUpload">

                            <i class="bi bi-image-fill"></i>

                        </label>


                        <input

                            id="imageUpload"

                            type="file"

                            name="image"

                            class="d-none"

                            accept="image/*">


                        {{-- Prompt --}}

                        <textarea

                            id="promptInput"

                            name="prompt"

                            class="search-input"

                            placeholder="Describe the place you want to visit...">{{ old('prompt') }}</textarea>


                        {{-- Search button --}}

                        <button

                            id="submitBtn"

                            class="search-button"

                            type="submit">

                            <i class="bi bi-search"></i>

                        </button>

                    </div>


                    {{-- Preview image --}}

                    <div class="text-center mt-4">

                        <img

                            id="imagePreview"

                            class="preview-image d-none">

                    </div>


                    {{-- Search mode indicator --}}

                    <div class="text-center mt-4">

                        <small class="text-muted">

                            <i class="bi bi-lightbulb"></i>

                            You can search using

                            <strong>text</strong>,

                            <strong>an image</strong>,

                            or

                            <strong>both together</strong>.

                        </small>

                    </div>

                </form>

            </div>

        </div>

    </div>
    {{-- ========================================= --}}
{{-- AI CONVERSATION --}}
{{-- ========================================= --}}

@if(request()->filled('prompt') || request()->hasFile('image'))

<div class="chat-section mt-5">

    {{-- User message --}}

    <div class="chat-message user-message">

        <div class="chat-avatar">

            👤

        </div>

        <div class="chat-bubble user">

            @if(request()->filled('prompt'))

                <strong>Your request</strong>

                <br><br>

                {{ request('prompt') }}

            @endif

            @if(request()->hasFile('image'))

                @if(request()->filled('prompt'))

                    <hr>

                @endif

                <div class="mt-2">

                    <i class="bi bi-image-fill text-warning"></i>

                    Image uploaded

                </div>

            @endif

        </div>

    </div>


    {{-- AI message --}}

    @if(isset($aiMessage))

    <div id="aiConversation">

        <div class="chat-message ai-message">

            <div class="chat-avatar ai-avatar">

                ✨

            </div>

            <div class="chat-bubble ai">

                <div class="mb-2">

                    <strong>MarrakechTour AI</strong>

                </div>

                <span id="aiText">

                    {{ $aiMessage }}

                </span>

            </div>

        </div>

    </div>

    @endif

</div>

@endif
{{-- ========================================= --}}
{{-- SEARCH RESULTS --}}
{{-- ========================================= --}}

@if(isset($results) && count($results))

<section class="mt-5">

    <h2 class="section-title">

        ✨ {{ __('find_attraction.results') }}

    </h2>

    <div class="row g-4">

        @foreach($results as $attraction)

        <div class="col-lg-4 col-md-6">

            <div class="card attraction-card h-100 shadow">

                {{-- ========================= --}}
                {{-- Carousel --}}
                {{-- ========================= --}}

                @if($attraction->images->count())

                <div id="carousel{{ $attraction->id }}"
                     class="carousel slide"
                     data-bs-ride="carousel">

                    <div class="carousel-inner">

                        @foreach($attraction->images as $image)

                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                            <img

                                src="{{ asset('storage/'.$image->image) }}"

                                class="d-block w-100 attraction-image"

                                alt="{{ $attraction->attraction }}">

                        </div>

                        @endforeach

                    </div>

                    @if($attraction->images->count()>1)

                    <button

                        class="carousel-control-prev"

                        type="button"

                        data-bs-target="#carousel{{ $attraction->id }}"

                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                    </button>

                    <button

                        class="carousel-control-next"

                        type="button"

                        data-bs-target="#carousel{{ $attraction->id }}"

                        data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                    </button>

                    @endif

                </div>

                @elseif($attraction->photo)

                <img

                    src="{{ asset('storage/'.$attraction->photo) }}"

                    class="card-img-top attraction-image">

                @endif


                {{-- ========================= --}}
                {{-- Body --}}
                {{-- ========================= --}}

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-2">

                        {{ $attraction->attraction }}

                    </h5>


                    {{-- Similarity OpenCLIP --}}

                    @if(isset($attraction->similarity))

                    <div class="mb-3">

                        <span class="badge bg-success fs-6">

                            Similarity

                            {{ number_format($attraction->similarity*100,1) }}%

                        </span>

                    </div>

                    @endif


                    {{-- Type --}}

                    <span class="badge bg-warning text-dark mb-3">

                        {{ __('attractions.types.'.$attraction->type) }}

                    </span>


                    {{-- Description --}}

                    <p class="text-muted flex-grow-1">

                        {{ \Illuminate\Support\Str::limit(strip_tags($attraction->details),120) }}

                    </p>


                    {{-- Button --}}

                    <a

                        href="{{ route('attractions.show',$attraction->id) }}"

                        class="btn btn-warning rounded-pill mt-auto">

                        <i class="bi bi-eye-fill"></i>

                        {{ __('attractions.details') }}

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</section>

@endif
<style>
    /* ==========================================================
       GLOBAL & HERO
    ========================================================== */
    .text-brown {
        color: #8B4513 !important;
    }

    /* Style des badges / suggestion chips */
    .suggestion-chip {
        background-color: #ffffff !important;
        color: #8B4513 !important;
        border: 1px solid #e0e0e0;
        padding: 8px 16px !important;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .suggestion-chip:hover {
        background-color: #8B4513 !important;
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    /* ==========================================================
       SEARCH CARD & FORM
    ========================================================== */
    .search-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f0f0;
    }

    .search-header h3 {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border: 1.5px solid #e9ecef;
        border-radius: 20px;
        padding: 8px 12px;
        gap: 10px;
        margin-top: 20px;
        transition: border-color 0.3s ease;
    }

    .search-box:focus-within {
        border-color: #C96A2B;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(201, 106, 43, 0.1);
    }

    .image-button {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #f1f3f5;
        color: #8B4513;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        transition: 0.2s ease;
        flex-shrink: 0;
    }

    .image-button:hover {
        background: #e9ecef;
        color: #C96A2B;
    }

    .search-input {
        flex: 1;
        border: none;
        background: transparent;
        resize: none;
        outline: none;
        padding: 10px 5px 0 5px;
        font-size: 1rem;
        color: #333;
        height: 48px;
        line-height: 1.4;
    }

    .search-button {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #C96A2B;
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: 0.3s ease;
        flex-shrink: 0;
    }

    .search-button:hover {
        background: #8B4513;
    }

    /* ==========================================================
       CHAT
    ========================================================== */
    .chat-section {
        max-width: 1000px;
        margin: 60px auto;
    }

    .chat-message {
        display: flex;
        margin-bottom: 30px;
    }

    .user-message {
        justify-content: flex-end;
    }

    .ai-message {
        justify-content: flex-start;
    }

    .chat-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        background: #C96A2B;
        margin: 0 15px;
        flex-shrink: 0;
    }

    .ai-avatar {
        background: #8B4513;
    }

    .chat-bubble {
        max-width: 75%;
        padding: 20px 25px;
        border-radius: 22px;
        line-height: 1.8;
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }

    .chat-bubble.user {
        background: #C96A2B;
        color: white;
    }

    .chat-bubble.ai {
        background: white;
        border: 1px solid #ececec;
    }

    #aiText {
        white-space: pre-wrap;
    }

    /* ==========================================================
       RESULTS
    ========================================================== */
    .section-title {
        color: #8B4513;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
    }

    .attraction-card {
        border: none;
        border-radius: 22px;
        overflow: hidden;
        transition: .35s;
        background: white;
    }

    .attraction-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(0,0,0,.18);
    }

    .attraction-image {
        height: 250px;
        object-fit: cover;
        transition: .45s;
    }

    .attraction-card:hover .attraction-image {
        transform: scale(1.08);
    }

    .attraction-card .card-body {
        padding: 22px;
    }

    .attraction-card h5 {
        color: #8B4513;
        font-weight: 700;
    }

    .badge.bg-success {
        background: #198754 !important;
        font-size: .9rem;
    }

    .badge.bg-warning {
        font-size: .85rem;
    }

    .btn-warning {
        background: #C96A2B;
        border: none;
        transition: .3s;
        color: white;
    }

    .btn-warning:hover {
        background: #8B4513;
        color: white;
    }

    /* ==========================================================
       CAROUSEL & PREVIEW
    ========================================================== */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0,0,0,.45);
        border-radius: 50%;
        padding: 18px;
    }

    .preview-image {
        max-height: 220px;
        border-radius: 20px;
        box-shadow: 0 12px 25px rgba(0,0,0,.18);
    }

    /* ==========================================================
       RESPONSIVE
    ========================================================== */
    @media(max-width: 768px) {
        .search-box {
            flex-direction: column;
            align-items: stretch;
        }

        .image-button,
        .search-button {
            width: 100%;
            border-radius: 16px;
        }

        .chat-bubble {
            max-width: 100%;
        }
    }
</style>
<script>
const imageInput = document.getElementById("imageUpload");
const preview = document.getElementById("imagePreview");

if(imageInput){

    imageInput.addEventListener("change",function(){

        if(this.files.length){

            preview.src = URL.createObjectURL(this.files[0]);

            preview.classList.remove("d-none");

        }else{

            preview.classList.add("d-none");

        }

    });

}

/*
|--------------------------------------------------------------------------
| Suggestion Chips
|--------------------------------------------------------------------------
*/

document.querySelectorAll(".clickable-chip").forEach(chip=>{

    chip.addEventListener("click",function(){

        const textarea=document.getElementById("promptInput");

        textarea.value=this.dataset.prompt;

        textarea.focus();

        textarea.style.height="auto";

        textarea.style.height=textarea.scrollHeight+"px";

    });

});

/*
|--------------------------------------------------------------------------
| Auto Resize Textarea
|--------------------------------------------------------------------------
*/

const textarea=document.getElementById("promptInput");

if(textarea){

    textarea.addEventListener("input",function(){

        this.style.height="auto";

        this.style.height=this.scrollHeight+"px";

    });

}

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

const form=document.getElementById("findForm");

if(form){

form.addEventListener("submit",function(e){

    const hasImage=imageInput.files.length>0;

    const hasPrompt=textarea.value.trim().length>0;

    if(!hasImage && !hasPrompt){

        e.preventDefault();

        alert("Please enter a description or upload an image.");

        return;

    }

    const btn=document.getElementById("submitBtn");

    btn.disabled=true;

    btn.innerHTML=`

        <span class="spinner-border spinner-border-sm"></span>

    `;

});

}

/*
|--------------------------------------------------------------------------
| Cards Animation
|--------------------------------------------------------------------------
*/

window.addEventListener("load",()=>{

    const cards=document.querySelectorAll(".attraction-card");

    cards.forEach((card,index)=>{

        card.style.opacity=0;

        card.style.transform="translateY(40px)";

        setTimeout(()=>{

            card.style.transition=".6s";

            card.style.opacity=1;

            card.style.transform="translateY(0)";

        },index*120);

    });

});

/*
|--------------------------------------------------------------------------
| Scroll to results
|--------------------------------------------------------------------------
*/

const results=document.querySelector(".section-title");

if(results){

    setTimeout(()=>{

        results.scrollIntoView({

            behavior:"smooth",

            block:"start"

        });

    },300);

}

/*
|--------------------------------------------------------------------------
| AI Typing Effect
|--------------------------------------------------------------------------
*/

const aiText=document.getElementById("aiText");

if(aiText){

    const message=aiText.innerText;

    aiText.innerHTML="";

    let i=0;

    function typing(){

        if(i<message.length){

            aiText.innerHTML+=message.charAt(i);

            i++;

            setTimeout(typing,18);

        }

    }

    setTimeout(typing,300);

}
</script>
@endsection