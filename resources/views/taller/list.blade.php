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

        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Descripcio</th>
                    <th scope="col">Adreçat a</th>
                    <th scope="col">Places</th>
                    @if (Auth::User()->isTeacher())
                    <th scope="col"></th>
                    @endif
                    {{-- <th scope="col">Nº alumnes</th> --}}
                    {{-- <th scope="col">Material</th> --}}
                    {{-- <th scope="col">Observacions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($tallers as $taller)
                <tr>
                    <td>
                        <a class="" href="{{ route('showTaller', $taller->id) }}">
                            {{$taller->name}}
                        </a>
                        @if($taller->user_id == Auth::User()->id || Auth::User()->isTeacher())
                        <span class="mx-1">-</span>
                        <a href="{{ route('showTaller', $taller->id) }}/edit"><i class="bi bi-pencil"></i></a>

                        @endif
                    </td>
                    <td>{{ $taller->description }}</td>
                    <td>{{ implode(', ', $taller->addressed_to) }}</td>
                    <td>TODO</td>
                    {{-- <td>{{ $taller->max_students }}</td> --}}
                    {{-- <td>{{ $taller->material }}</td> --}}
                    {{-- <td>{{ $taller->observations }}</td> --}}
                    {{-- @if ($taller->user_id == Auth::User()->id || Auth::User()->isTeacher())
                    <td><a class="btn btn-primary text-nowrap" href="{{ route('showTaller', $taller->id) }}/edit"><i class="bi bi-pencil"></i>
                    Modificar </a></td>
                    @endif --}}
                    {{-- <td><a class="btn btn-primary text-nowrap" href="">Apuntar-se</a></td> --}}

                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- @foreach ($tallers as $taller)
            <div class="row bg-light mb-3 rounded">
                <div class="col-3  row">
                    <a class="align-middle" href="{{ route('showTaller', $taller->id) }}">{{ $taller->name }}</a>
    </div>
    <div class="col bg-danger">
        <p>
            {{ $taller->description }}
        </p>
        {{ implode(', ', $taller->addressed_to) }}
    </div>

    @if (Auth::User()->isTeacher())
    <a class="btn btn-primary text-nowrap" href="{{ route('showTaller', $taller->id) }}">Modificar</a>
    @endif
    <a class="btn btn-primary text-nowrap" href="">Apuntar-se</a>
    </div>
    @endforeach --}}
    {{ $tallers->links() }}



    {{-- {{dd($taller)}} --}}

    </div>
    @include('common.bootstrap-body')
</body>

</html>
