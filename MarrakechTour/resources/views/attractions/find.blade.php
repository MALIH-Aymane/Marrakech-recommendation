@extends('layouts.app')

@section('title', __('find_attraction.title'))

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold" style="color:#8B4513;">
            ✨ {{ __('find_attraction.title') }}
        </h2>

        <p class="text-muted">
            {{ __('find_attraction.subtitle') }}
        </p>

    </div>

    {{-- Suggestions --}}
    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">

      <span class="badge rounded-pill suggestion-chip clickable-chip"
      data-prompt="{{ __('find_attraction.garden') }}">
    🌿 {{ __('find_attraction.garden') }}
</span>

<span class="badge rounded-pill suggestion-chip clickable-chip"
      data-prompt="{{ __('find_attraction.history') }}">
    🕌 {{ __('find_attraction.history') }}
</span>

<span class="badge rounded-pill suggestion-chip clickable-chip"
      data-prompt="{{ __('find_attraction.museum') }}">
    🎨 {{ __('find_attraction.museum') }}
</span>

<span class="badge rounded-pill suggestion-chip clickable-chip"
      data-prompt="{{ __('find_attraction.relax') }}">
    ☕ {{ __('find_attraction.relax') }}
</span>

<span class="badge rounded-pill suggestion-chip clickable-chip"
      data-prompt="{{ __('find_attraction.sunset') }}">
    🌅 {{ __('find_attraction.sunset') }}
</span>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    <form id="findForm" action="{{ route('find.attraction') }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="mb-4">

    <label class="form-label fw-semibold">
        {{ __('find_attraction.describe') }}
    </label>

    <div class="chat-input-container">

        {{-- Bouton Image --}}
        <label for="imageUpload" class="image-btn">

            <i class="bi bi-image-fill"></i>

        </label>

        <input
            id="imageUpload"
            name="image"
            type="file"
            class="d-none"
            accept="image/*">

        {{-- Zone de texte --}}
        <textarea
            id="promptInput"
            class="prompt-input"
            name="prompt"
            rows="2"
            placeholder="{{ __('find_attraction.placeholder') }}">{{ old('prompt') }}</textarea>

        {{-- Bouton Envoyer --}}
        <button
            type="submit"
            class="send-btn">

            <i class="bi bi-send-fill"></i>

        </button>

    </div>

    {{-- Aperçu de l'image --}}
    <div class="mt-3 text-center">

        <img
            id="imagePreview"
            class="img-fluid rounded-4 shadow d-none"
            style="max-height:180px;object-fit:cover;">

    </div>

</div>
@if(request()->filled('prompt'))
    {{-- User message --}}
    <div class="chat-message user-message">

        <div class="chat-avatar">
            👤
        </div>

        <div class="chat-bubble user">

            {{ request('prompt') }}

        </div>

    </div>

    {{-- AI message --}}
    <div id="aiConversation">

    <div class="chat-message ai-message">

        <div class="chat-avatar">
            ✨
        </div>

        <div class="chat-bubble ai">

            <span id="aiText">

                {{ $aiMessage }}

            </span>

        </div>

    </div>

</div>

@endif
    {{-- Recommendations --}}
    @if(isset($recommendations) && $recommendations->count())

    <div class="mt-5">

        <h3 class="fw-bold text-center mb-4" style="color:#8B4513;">

            ✨ {{ __('find_attraction.results') }}

        </h3>

        <div class="row g-4">

            @foreach($recommendations as $attraction)

                <div class="col-md-6 col-lg-4 d-flex">

                    <div class="card border-0 shadow feature-card h-100 w-100 recommendation-card">

                        @if($attraction->photo)

                            <img
                                src="{{ asset('storage/'.$attraction->photo) }}"
                                class="card-img-top">

                        @endif

                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-bold">

                                {{ $attraction->attraction }}

                            </h5>

                            <span class="badge bg-warning text-dark mb-3">

                                {{ __('attractions.types.' . $attraction->type) }}

                            </span>

                            <p class="text-muted flex-grow-1">

                                {{ \Illuminate\Support\Str::limit(strip_tags($attraction->details),100) }}

                            </p>

                            <a href="{{ route('attractions.show',$attraction->id) }}"
                               class="btn btn-warning rounded-pill">

                                {{ __('attractions.details') }}

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    @endif

</div>

<style>

.suggestion-chip{

    background:#fff8ef;
    color:#8B4513;
    border:1px solid rgba(201,106,43,.2);
    padding:10px 18px;
    font-size:.95rem;
    cursor:pointer;
    transition:.3s;

}

.suggestion-chip:hover{

    background:#C96A2B;
    color:white;
    transform:translateY(-3px);

}

.chat-input-container{

    display:flex;
    align-items:flex-end;
    gap:12px;

    background:white;
    border:2px solid #eee;
    border-radius:24px;
    padding:12px 16px;

    transition:.3s;
    box-shadow:0 8px 20px rgba(0,0,0,.05);

}

.chat-input-container:focus-within{

    border-color:#C96A2B;
    box-shadow:0 0 0 .25rem rgba(201,106,43,.15);

}

.prompt-input{

    flex:1;
    border:none;
    outline:none;
    resize:none;
    background:transparent;

    min-height:45px;
    max-height:180px;
}

.image-btn{

    width:42px;
    height:42px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#FFF4EA;
    color:#C96A2B;

    cursor:pointer;
    transition:.3s;
}

.image-btn:hover{

    background:#C96A2B;
    color:white;

}

.image-btn i{

    font-size:1.2rem;

}

.send-btn{

    width:45px;
    height:45px;

    border:none;
    border-radius:50%;

    background:#C96A2B;
    color:white;

    transition:.3s;

}

.send-btn:hover{

    background:#8B4513;

}

.prompt-input{

    width:100%;
    border:none;
    resize:none;
    outline:none;
    background:transparent;
    font-size:1rem;
    min-height:140px;

}

.feature-card{

    border-radius:22px;
    overflow:hidden;
    transition:.35s;

}

.feature-card:hover{

    transform:translateY(-8px);
    box-shadow:0 18px 35px rgba(0,0,0,.18);

}

.feature-card img{

    height:220px;
    object-fit:cover;

}

.btn-warning{

    background:#C96A2B;
    border:none;

}

.btn-warning:hover{

    background:#8B4513;

}
.chat-area{

    max-width:900px;
    margin:auto;
    margin-top:50px;

}

.chat-message{

    display:flex;
    align-items:flex-start;
    margin-bottom:25px;

}

.user-message{

    justify-content:flex-end;

}

.ai-message{

    justify-content:flex-start;

}

.chat-avatar{

    width:45px;
    height:45px;
    border-radius:50%;
    background:#C96A2B;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    margin:0 12px;

}

.chat-bubble{

    max-width:70%;
    padding:18px 22px;
    border-radius:22px;
    font-size:1rem;
    line-height:1.7;

}

.chat-bubble.user{

    background:#C96A2B;
    color:white;

}

.chat-bubble.ai{

    background:#F9F6F1;
    color:#333;
    border:1px solid #eee;

}
.recommendation-card{

    opacity:0;
    transform:translateY(35px);

    transition:
        opacity .6s ease,
        transform .6s ease;

}

.recommendation-card.show{

    opacity:1;
    transform:translateY(0);

}
#aiText{

    white-space:pre-wrap;

}
</style>

<script>
const imageInput = document.getElementById('imageUpload');
const preview = document.getElementById('imagePreview');
const promptInput = document.getElementById('promptInput');
const chips = document.querySelectorAll('.clickable-chip');
const form = document.getElementById('findForm');
const submitBtn = document.getElementById('submitBtn');
const btnText = document.getElementById('btnText');

/*
|--------------------------------------------------------------------------
| Image Preview
|--------------------------------------------------------------------------
*/

imageInput.addEventListener('change', function () {

    if (this.files.length > 0) {

        preview.src = URL.createObjectURL(this.files[0]);

        preview.classList.remove('d-none');

    }

});

/*
|--------------------------------------------------------------------------
| Suggestion Chips
|--------------------------------------------------------------------------
*/

chips.forEach(chip => {

    chip.addEventListener('click', function () {

        promptInput.value = this.dataset.prompt;

        promptInput.focus();

    });

});

/*
|--------------------------------------------------------------------------
| Loading Button
|--------------------------------------------------------------------------
*/

form.addEventListener('submit', function () {

    submitBtn.disabled = true;

    btnText.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Searching...
    `;

});
const cards = document.querySelectorAll('.recommendation-card');

cards.forEach((card,index)=>{

    setTimeout(()=>{

        card.classList.add('show');

    },index*180);

});
/*
|--------------------------------------------------------------------------
| AI Typing Effect
|--------------------------------------------------------------------------
*/

const aiText = document.getElementById('aiText');

if(aiText){

    const message = aiText.innerText;

    aiText.innerHTML = "";

    let i = 0;

    function typeWriter(){

        if(i < message.length){

            aiText.innerHTML += message.charAt(i);

            i++;

            setTimeout(typeWriter,20);

        }

    }

    setTimeout(typeWriter,500);

}

document.addEventListener('DOMContentLoaded', function () {

    const conversation = document.getElementById('aiConversation');

    if (conversation) {

        conversation.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }

});


</script>

@endsection