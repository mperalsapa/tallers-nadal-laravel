<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Importacio d'usuaris</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container mt-5">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Importar usuaris</li>
            </ol>
        </nav>
        <h1>Registre d'importacio d'usuaris</h1>

        {{-- create a "console like" container to display log messages --}}
        <div class="container-fluid border border-dark" style="height: 70vh; overflow-y: scroll;">
            @foreach ($userCreationLog as $line)
                <p>{{ $line }}</p>
            @endforeach
        </div>




    </div>
    @include('common.bootstrap-body')

</body>

</html>
