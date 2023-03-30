<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Taller del historic - {{ $workshop->name }}</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Tallers</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('showWorkshopsHistory') }}">Historic</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $workshop->name }}</li>
            </ol>
        </nav>
        <div class="d-flex gap-3">

            <div class="col bg-light rounded p-2">

                <h1>{{ $workshop->name }}</h1>
                <h2>Descripcio</h2>
                <p>{{ $workshop->description }}</p>
                <h2>Adreçat a</h2>
                <div class="d-flex gap-1 flex-wrap">
                    @foreach ($workshop->addressed_to as $course)
                        <span class="btn btn-clear border border-dark">{{ $courseList[$course] }}</span>
                    @endforeach
                </div>
                <h2>Plaçes maximes</h2>
                <p>{{ $workshop->max_students }}</p>
                <h2>Material necessari</h2>
                <p>{{ $workshop->material }}</p>
                <h2>Observacions</h2>
                <p>{{ $workshop->observations }}</p>
            </div>

            @if (Auth::User()->isAdmin() || !Auth::User()->hasSelectWorkshopStarted())

                <div class="col-3">
                    <div class="col d-flex flex-column bg-light rounded p-2">
                        <h2 class="text-center">Opcions</h2>
                        <form class="d-flex flex-column gap-2" action="{{ route('storeWorkshopsHistory') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="workshopId" value="{{ $workshop->id }}">
                            <button type="submit" name="submit" value="copy" class="btn btn-primary">
                                @if (Auth::User()->workshop && !Auth::User()->isAdmin())
                                    Copiar informacio al meu taller
                                @else
                                    Crear taller basat en aquest
                                @endif
                            </button>
                            @if (Auth::User()->isAdmin())
                                {{-- <button type="submit" name="submit" value="edit" class="btn btn-primary">
                                    Modificar taller
                                </button> --}}
                                <button type="submit" name="submit" value="remove" class="btn btn-danger">
                                    Esborrar taller
                                </button>
                            @endif
                            </a>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('common.bootstrap-body')
</body>

</html>
