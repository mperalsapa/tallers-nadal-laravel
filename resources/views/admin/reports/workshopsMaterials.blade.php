<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de materials de taller</title>
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
                <li class="breadcrumb-item active" aria-current="page">Materials de tallers</li>
            </ol>
        </nav>
        <h1>Imprimir informe</h1>
        <p>Fes clic en imprimir per previsualitzar i imprimir l'informe.</p>
        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
    </div>

    <table class="table table-bordered d-none d-print-block">

        <thead>
            <tr>
                <th>Taller</th>
                <th>Material</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workshops as $workshop)
                <tr>
                    <td>{{ $workshop->name }}</td>
                    <td>{{ $workshop->material }}</td>
                    <td>{{ $workshop->manager }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('common.bootstrap-body')
</body>

</html>
