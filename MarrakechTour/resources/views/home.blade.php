@extends('layouts.app')

@section('title', __('home.title'))

@section('content')


<section class="hero">

    <div class="hero-overlay"></div>

    <div class="container hero-content">

        <div class="text-center">


            <h1 class="display-2 fw-bold mb-4">
                   {!! __('home.hero_title') !!}
                  </h1>


            <p class="lead mb-5">

               {{ __('home.hero_subtitle') }}

            </p>


        </div>

    </div>


    <svg class="wave"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 1440 320">

        <path fill="#f8f4ef"
              fill-opacity="1"
              d="M0,224L60,202.7C120,181,240,139,360,122.7C480,107,600,117,720,138.7C840,160,960,192,1080,197.3C1200,203,1320,181,1380,170.7L1440,160L1440,320L0,320Z">

        </path>

    </svg>


</section>



<section class="container py-5">


    <div class="text-center mb-5">


        <h2 class="fw-bold" style="color:#8B4513;">

          {{ __('home.inspirations') }}

        </h2>


        <p class="text-muted">

           {{ __('home.inspirations_text') }}

        </p>


    </div>



    <div class="row g-4">


        @foreach($attractions as $attraction)


        <div class="col-md-4">


            <div class="card feature-card h-100 shadow">


                @if($attraction->photo)

                <img
                    src="{{ asset('storage/'.$attraction->photo) }}"
                    class="card-img-top"
                    style="height:250px;object-fit:cover;">

                @else

                <img
                    src="https://placehold.co/400x250?text=Aucune+Image"
                    class="card-img-top"
                    style="height:250px;object-fit:cover;">

                @endif



                <div class="card-body text-center">



                    <h5 class="fw-bold mb-3">

                        {{ $attraction->attraction }}

                    </h5>



                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">


                        <span class="badge rounded-pill"
                              style="background:#C96A2B;font-size:12px;">

                            {{ $attraction->type ?? __('home.tourist_attraction') }}

                        </span>



                        <span class="text-muted small fw-semibold">

                            <i class="bi bi-star-fill text-warning"></i>

                            {{ number_format($attraction->rate,1) }}/5

                        </span>


                    </div>




                    <a href="{{ route('attractions.show',$attraction->id) }}"
                       class="btn btn-outline-warning rounded-pill">


                        <i class="bi bi-eye-fill"></i>

                      {{ __('home.details') }}


                    </a>



                </div>


            </div>


        </div>


        @endforeach



    </div>


</section>
<!-- ================= POURQUOI MARRAKECH ================= -->


<section class="container py-5">


<div class="text-center mb-5">


<h2 class="fw-bold" style="color:#8B4513;">

{{ __('home.why') }}

</h2>


<p class="text-muted">

{{ __('home.why_text') }}

</p>


</div>



<div class="row g-4">



<div class="col-md-4">


<div class="card feature-card p-4 h-100 text-center">


<i class="bi bi-bank fs-1 text-warning"></i>


<h4 class="mt-3">

{{ __('home.heritage') }}

</h4>


<p>

{{ __('home.heritage_text') }}

</p>


</div>


</div>




<div class="col-md-4">


<div class="card feature-card p-4 h-100 text-center">


<i class="bi bi-tree-fill fs-1 text-success"></i>


<h4 class="mt-3">

{{ __('home.nature') }}

</h4>


<p>

{{ __('home.nature_text') }}

</p>


</div>


</div>





<div class="col-md-4">


<div class="card feature-card p-4 h-100 text-center">


<i class="bi bi-cup-hot-fill fs-1 text-danger"></i>


<h4 class="mt-3">

{{ __('home.culture') }}

</h4>


<p>

{{ __('home.culture_text') }}

</p>


</div>


</div>



</div>


</section>






<!-- ================= GALERIE ================= -->


<section class="container py-5">


<div class="text-center mb-5">


<h2 class="fw-bold" style="color:#8B4513;">

{{ __('home.gallery') }}

</h2>


<p class="text-muted">

{{ __('home.gallery_text') }}

</p>


</div>



<div class="row g-4">



<div class="col-md-4">


<div class="card feature-card border-0 shadow-lg overflow-hidden">


<img src="{{ asset('images/jd.jpg') }}"
     class="card-img-top"
     style="height:250px;object-fit:cover;">



<div class="card-body text-center">


<h5 class="fw-bold">

{{ __('home.majorelle') }}

</h5>


<p class="text-muted">

{{ __('home.majorelle_text') }}

</p>


</div>


</div>


</div>





<div class="col-md-4">


<div class="card feature-card border-0 shadow-lg overflow-hidden">


<img src="{{ asset('images/bahia-palace-room.webp') }}"
     class="card-img-top"
     style="height:250px;object-fit:cover;">



<div class="card-body text-center">


<h5 class="fw-bold">

{{ __('home.bahia') }}

</h5>


<p class="text-muted">

{{ __('home.bahia_text') }}

</p>


</div>


</div>


</div>





<div class="col-md-4">


<div class="card feature-card border-0 shadow-lg overflow-hidden">


<img src="{{ asset('images/jemaa-elfnaa-at-night.webp') }}"
     class="card-img-top"
     style="height:250px;object-fit:cover;">



<div class="card-body text-center">


<h5 class="fw-bold">

{{ __('home.jemaa') }}

</h5>


<p class="text-muted">

{{ __('home.jemaa_text') }}

</p>


</div>


</div>


</div>




</div>


</section>







<!-- ================= APPEL A L'ACTION ================= -->


<section class="py-5">


<div class="container">


<div class="glass text-center p-5">


<h2 class="fw-bold mb-4">

{{ __('home.ready') }}

</h2>



<p class="mb-4">

{{ __('home.ready_text') }}

</p>




<a href="{{ route('attractions.index') }}"
   class="btn btn-warning btn-lg rounded-pill px-5">


<i class="bi bi-compass-fill"></i>


{{ __('home.start') }}


</a>



</div>


</div>


</section>







<style>


.hero{


height:90vh;

background:url("{{ asset('images/marrakech.png') }}") center center/cover no-repeat;

position:relative;

display:flex;

align-items:center;

justify-content:center;

overflow:hidden;


}



.hero-overlay{


position:absolute;

inset:0;

background:rgba(0,0,0,.55);

backdrop-filter:blur(2px);


}



.hero-content{


position:relative;

z-index:2;

color:white;


}



.hero h1{


font-weight:700;


}


.wave{

position:absolute;

bottom:-80px;

left:0;

width:100%;

}



.glass{


background:white;

border-radius:25px;

box-shadow:0 10px 35px rgba(0,0,0,.12);

padding:30px;


}



.feature-card{


transition:.4s;

border-radius:20px;


}



.feature-card:hover{


transform:translateY(-12px);

box-shadow:0 20px 40px rgba(0,0,0,.2);


}



.card img{


transition:.5s;


}



.card:hover img{


transform:scale(1.08);


}



.btn-warning{


background:#C96A2B;

border:none;


}



.btn-warning:hover{


background:#8B4513;


}



@keyframes fadeUp{


from{


opacity:0;

transform:translateY(40px);


}


to{


opacity:1;

transform:translateY(0);


}


}



.hero-content{


animation:fadeUp 1.2s ease;


}



</style>




<script>


document.querySelectorAll(".counter").forEach(counter=>{


const target=parseFloat(counter.dataset.target);


let value=0;


const speed=target/120;



function update(){


if(value<target){


value+=speed;


if(target<10){


counter.innerHTML=value.toFixed(1);


}

else{


counter.innerHTML=Math.floor(value);


}


requestAnimationFrame(update);


}

else{


counter.innerHTML=target;


}


}



update();



});


</script>



@endsection