<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de seleccions de taller per alumne</title>
    @include('common.bootstrap-header')
    <style>
        @media print {
            table {
                page-break-after: always
            }
        }
    </style>

</head>

<body>
    @include('admin.navbar')

    <div class="d-print-none container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('adminShowSetting') }}">Informe</a></li>
                <li class="breadcrumb-item active" aria-current="page">Eleccions d'usuaris</li>
            </ol>
        </nav>
        <h1>Imprimir informe</h1>
        <p>Fes clic en imprimir per previsualitzar i imprimir l'informe.</p>
        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
    </div>

    <table class="table table-bordered d-none d-print-block">
        {{-- <table class="table table-bordered d-print-block"> --}}

        <thead>
            <tr>
                <th>Alumne</th>
                <th>Etapa</th>
                <th>Curs</th>
                <th>Grup</th>
                <th>Opcio 1</th>
                <th>Opcio 2</th>
                <th>Opcio 3</th>
                <th>Assignat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($choices as $choice)
                {{-- @continue($choice->user->isAdmin()) --}}
                <tr>
                    <td>{{ $choice->user->name . ' ' . $choice->user->surname }}</td>
                    <td>{{ $choice->user->stage }}</td>
                    <td>{{ $choice->user->course }}</td>
                    <td>{{ $choice->user->group }}</td>
                    <td>{{ optional($choice->firstChoice)->name }}</td>
                    <td>{{ optional($choice->secondChoice)->name }}</td>
                    <td>{{ optional($choice->thirdChoice)->name }}</td>
                    <td>{{ optional($choice->assigned)->name }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    @include('common.bootstrap-body')

</body>

</html>
