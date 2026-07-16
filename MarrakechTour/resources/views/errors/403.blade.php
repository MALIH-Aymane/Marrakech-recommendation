<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accès refusé</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f8f4ef;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            font-family:Poppins,sans-serif;
        }

        .card{
            max-width:600px;
            text-align:center;
            border:none;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(0,0,0,.1);
            padding:40px;
        }

        h1{
            color:#A45A2A;
            font-size:80px;
            font-weight:bold;
        }

    </style>

</head>

<body>

<div class="card">

    <h1>403</h1>

    <h3>Accès refusé</h3>

    <p class="text-muted">

        Vous n'avez pas les autorisations nécessaires pour accéder à cette page.

    </p>

    <a href="{{ route('home') }}" class="btn btn-warning">

        Retour à l'accueil

    </a>

</div>

</body>
</html>
