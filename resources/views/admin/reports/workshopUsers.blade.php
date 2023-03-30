<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe d'alumnes per taller</title>
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
                <li class="breadcrumb-item active" aria-current="page">Usuaris per taller</li>
            </ol>
        </nav>
        <h1>Imprimir informe</h1>
        <p>Fes clic en imprimir per previsualitzar i imprimir l'informe.</p>
        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
    </div>

    @foreach ($workshops as $workshop)
        @php
            $users = $workshop->users;
            
        @endphp
        @if ($users->count() > 0)
            <table class="table table-bordered d-none d-print-block">

                <thead>
                    <tr>
                        <th style="width:10%" rowspan="3">Nº Alumnes</th>
                        <th>Taller: {{ $workshop->name }}</th>
                        <th colspan="2">Aula/espai: {{ $workshop->place ?? "No s'ha assignat un espai" }}</th>
                    </tr>
                    <tr>
                        <th>Responsable: {{ $workshop->manager }}</th>

                        <th>Suport: {{ $workshop->assistants }}</th>


                    </tr>
                    <tr>
                        <th>Alumnat</th>
                        <th>Curs/Grup</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        {{-- @continue($user->isAdmin()) --}}
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $user->name . ' ' . $user->surname }}</td>
                            <td>{{ $user->fullCourseName() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
    @include('common.bootstrap-body')
</body>

</html>
