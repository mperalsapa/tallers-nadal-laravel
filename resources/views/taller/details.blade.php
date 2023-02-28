<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container">

        <div class="d-flex pt-5  gap-5">
            <div class="col bg-light rounded p-2">
                <h1>{{ $taller->name }}</h1>
                <h2>Descripcio</h2>
                <p>{{ $taller->description }}</p>
                <h2>Adreçat a</h2>
                <div class="d-flex gap-1 flex-wrap">
                    @foreach ($taller->addressed_to as $course)
                        <span class="btn btn-primary">{{ $courseList[$course] }}</span>
                    @endforeach
                </div>
                <h2>Plaçes maximes</h2>
                <p>{{ $taller->max_students }}</p>
                <h2>Material necessari</h2>
                <p>{{ $taller->material }}</p>
                <h2>Observacions</h2>
                <p>{{ $taller->observations }}</p>
            </div>
            @if (Auth::User()->isAdmin())
                <div class="d-flex flex-column bg-light rounded p-2">
                    <h2>Administració</h2>
                    <a class="btn btn-primary mt-3" href="">Editar Taller</a>
                    <a class="btn btn-primary mt-3" href="">Esborrar Taller</a>
                </div>
            @endif
        </div>
    </div>
    @include('common.bootstrap-body')
</body>

</html>
