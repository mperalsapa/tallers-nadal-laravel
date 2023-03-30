<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Taller - {{ $workshop->name }}</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Tallers</a>
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
                        <a href="{{ route('index', ['addressedTo' => $course]) }}"
                            class="btn btn-primary">{{ $courseList[$course] }}</a>
                    @endforeach
                </div>
                <h2>Plaçes maximes</h2>
                <p>{{ $workshop->max_students }}</p>
                <h2>Material necessari</h2>
                <p>{{ $workshop->material }}</p>
                <h2>Observacions</h2>
                <p>{{ $workshop->observations }}</p>
                @if (Auth::User()->isTeacher())
                    <h2>Ajudants</h2>
                    @if ($workshop->assistants)
                        <p>{{ $workshop->assistants }}</p>
                    @else
                        <p>No hi ha ajudants assignats</p>
                    @endif
                    <h2>Responsable</h2>
                    @if ($workshop->manager)
                        <p>{{ $workshop->manager }}</p>
                    @else
                        <p>No hi ha un responsable assignat</p>
                    @endif
                    <h2>Aula / Espai</h2>
                    @if ($workshop->place)
                        <p>{{ $workshop->place }}</p>
                    @else
                        <p>No s'ha assignat un espai</p>
                    @endif
                @endif
            </div>
            @if (Auth::User()->isSelectWorkshopPeriod() || $workshop->user_id == Auth::User()->id || Auth::User()->isAdmin())
                <div class="col-3">
                    <div class="col d-flex flex-column bg-light rounded p-2">
                        <h2 class="text-center">Opcions</h2>
                        @if (Auth::User()->isAdmin() || ($workshop->user_id == Auth::User()->id && !Auth::User()->hasSelectWorkshopStarted()))
                            <a class="btn btn-primary mt-3" href="{{ route('editWorkshop', $workshop->id) }}">Editar
                                Taller</a>
                        @endif
                        @if (Auth::User()->isAdmin())
                            <form action="{{ Route('cloneWorkshop', $workshop->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 mt-3">Duplicar</button>
                            </form>
                        @endif
                        @if (Auth::User()->isSelectWorkshopPeriod() && !Auth::User()->isTeacher())
                            <h3 id="select-workshop-label">Seleccionar taller</h3>
                            @if (!in_array($workshop->id, Auth::User()->workshopChoicesId()))
                                <form action="{{ route('selectWorkshop') }}" method="POST">
                                    @csrf
                                    <div class="mb-3" aria-labelledby="select-workshop-label">
                                        <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                                        <select class="form-select form-select-lg" name="selection" id="">
                                            <option value="" selected>Seleccionar opció</option>
                                            @if (Auth::User()->firstWorkshopChoice)
                                                <option value="first">Sobreescriure primera opcio</option>
                                            @else
                                                <option value="first">Primera opció</option>
                                            @endif
                                            @if (Auth::User()->secondWorkshopChoice)
                                                <option value="second">Sobreescriure segona opcio</option>
                                            @else
                                                <option value="second">Segona opció</option>
                                            @endif
                                            @if (Auth::User()->thirdWorkshopChoice)
                                                <option value="third">Sobreescriure tercera opcio</option>
                                            @else
                                                <option value="third">Tercera opció</option>
                                            @endif
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                                </form>
                            @else
                                <form action="{{ route('selectWorkshop') }}" method="POST">
                                    @csrf
                                    <p>Ja has seleccionat aquest taller</p>
                                    <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                                    <button type="submit" name="selection" value="deselect"
                                        class="btn btn-primary">Desapuntar-se</button>
                                </form>
                            @endif
                        @endif
                        {{-- @if ($userAsignedWorkshops && (Auth::User()->id == $workshop->user_id || Auth::User()->isAdmin()) && !Auth::User()->isSelectWorkshopPeriod() && Auth::User()->hasSelectWorkshopStarted())
                            <h3>Generar informe</h3>
                        @endif --}}
                    </div>
                </div>
            @endif

        </div>
    </div>
    @include('common.bootstrap-body')
</body>

</html>
