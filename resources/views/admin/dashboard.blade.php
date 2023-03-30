<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panell d'administracio</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Administracio</li>
            </ol>
        </nav>
        <h1>Panell d'administracio</h1>
        <div class="col">
            <div class="d-flex gap-2 mt-3">
                <div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">Activitat recent (1hr)</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recentActivityCount }}</h5>
                        <p class="card-text">Usuaris que han visitat el lloc en l'anterior hora</p>
                    </div>
                </div>
                <div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">Activitat recent (1 setmana)</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $activeUserCount }}</h5>
                        <p class="card-text">Usuaris que han iniciat sessio en l'anterior setmana</p>
                    </div>
                </div>
                <div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">Tallers creats</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $workshopCount }}</h5>
                        <p class="card-text">Tallers que s'han creat aquest any</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('common.bootstrap-body')
</body>

</html>
