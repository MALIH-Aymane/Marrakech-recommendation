@extends('layouts.crud')

@section('title','Dashboard Administrateur')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>

            <h2 class="fw-bold" style="color:#8B4513;">
                 Dashboard Administrateur
            </h2>

            <p class="text-muted">
                Vue d'ensemble de la plateforme Marrakech Tour.
            </p>

        </div>

        <div class="d-flex align-items-center gap-3">

    <a href="{{ route('dashboard.login.history') }}"
       class="btn btn-outline-primary">

        <i class="bi bi-clock-history"></i>
        Historique des connexions

    </a>

    <span class="badge bg-success fs-6 px-3 py-2">

        {{ now()->format('d/m/Y') }}

    </span>

</div>

    </div>

    <div class="row g-4">

        <!-- Attractions -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-geo-alt-fill fs-1 text-warning"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $totalAttractions }}

                    </h2>

                    <p class="text-muted mb-0">

                        Attractions

                    </p>

                </div>

            </div>

        </div>

        <!-- Utilisateurs -->

        <!-- Utilisateurs -->

<div class="col-lg-3 col-md-6">

    <a href="{{ route('users.index') }}"
       class="text-decoration-none text-dark">

        <div class="card shadow border-0 rounded-4 h-100 dashboard-card">

            <div class="card-body text-center">

                <i class="bi bi-people-fill fs-1 text-primary"></i>

                <h2 class="fw-bold mt-3">

                    {{ $totalUsers }}

                </h2>

                <p class="text-muted mb-0">

                    Utilisateurs

                </p>

            </div>

        </div>

    </a>

</div>
        <!-- Photos -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-image-fill fs-1 text-success"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $photos }}

                    </h2>

                    <p class="text-muted mb-0">

                        Attractions avec photo

                    </p>

                </div>

            </div>

        </div>

        <!-- Note moyenne -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-star-fill fs-1 text-danger"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $averageRate }}/5

                    </h2>

                    <p class="text-muted mb-0">

                        Note moyenne

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Dernières attractions -->

    <div class="card shadow border-0 rounded-4 mt-5">

        <div class="card-header bg-white">

            <h4 class="mb-0">

                 Dernières attractions ajoutées

            </h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th width=90>Photo</th>

                            <th width=250>Nom</th>

                            <th width=170>Type</th>

                            <th width=100>Note</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($lastAttractions as $attraction)

                        <tr>

                            <td width="90">

                                @if($attraction->photo)

                                    <img
                                        src="{{ asset('storage/'.$attraction->photo) }}"
                                        class="rounded"
                                        width="70"
                                        height="50"
                                        style="object-fit:cover;">

                                @endif

                            </td>

                           <td style="width:250px;">

    <span
        class="fw-semibold d-inline-block text-truncate"
        style="max-width:220px;"
        title="{{ $attraction->attraction }}">

        {{ $attraction->attraction }}

    </span>

</td>
<td style="width:170px;">

    <span class="badge bg-warning text-dark">

        {{ $attraction->type }}

    </span>

</td>

                            <td style="width:100px;">

    ⭐ {{ number_format($attraction->rate,1) }}

</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
        <!-- =================== Graphiques =================== -->

    <div class="row mt-5">

        <!-- Répartition des notes -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-white">

                    <h4 class="mb-0">

                        ⭐ Répartition des notes

                    </h4>

                </div>

                <div class="card-body">

                    <canvas id="ratingChart" height="280"></canvas>

                </div>

            </div>

        </div>

        <!-- Top 10 -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-white">

                    <h4 class="mb-0">

                        🏆 Top 10 des attractions

                    </h4>

                </div>

                <div class="card-body">

                    <canvas id="topChart" height="280"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ratingChart = new Chart(

document.getElementById('ratingChart'),

{

type:'bar',

data:{

labels:@json($ratingLabels),

datasets:[{

label:'Nombre d’attractions',

data:@json($ratingCounts),

backgroundColor:'#C96A2B',

borderRadius:8

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true,

ticks:{

stepSize:1

}

}

}

}

}

);



const topChart = new Chart(

document.getElementById('topChart'),

{

type:'bar',

data:{

labels:@json($topNames),

datasets:[{

label:'Note',

data:@json($topRates),

backgroundColor:'#8B4513',

borderRadius:8

}]

},

options:{

indexAxis:'y',

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

}

},

scales:{

x:{

min:0,

max:5

}

}

}

}

);

</script>
<style>

.dashboard-card{

    transition:.3s;

}

.dashboard-card:hover{

    transform:translateY(-6px);

    box-shadow:0 15px 35px rgba(0,0,0,.18);

}

.card-header{

    border-bottom:none;

    font-weight:600;

}

.table img{

    border-radius:10px;

}

.table th{

    color:#8B4513;

}

.table td{

    vertical-align:middle;

}

canvas{

    max-height:350px;

}

.badge{

    font-size:.85rem;

    padding:.55em .9em;

}

</style>

@endsection