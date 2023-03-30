<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Llista d'usuaris</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">Usuaris</li>
            </ol>
        </nav>
        <h1>Gestió d'usuaris</h1>
        @php
            if (count(request()->input()) > 2) {
                $showColapse = true;
            } else {
                $showColapse = false;
            }
            
        @endphp
        <div class="col">
            <button class="btn btn-light border" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterCollapse" aria-expanded="{{ $showColapse ? 'true' : 'false' }}"
                aria-controls="filterCollapse">
                <i class="bi bi-funnel"></i> Filtres
            </button>

            <div class="collapse {{ $showColapse ? 'show' : '' }} mt-3" id="filterCollapse">
                <div class="card card-body">
                    <div class="form-check col p-0 text-nowrap">
                        <form action="{{ route('adminShowUsers') }}" method="GET" class="">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        aria-describedby="helpId" placeholder="Nom de l'alumne"
                                        value="{{ request()->input('name') }}">
                                </div>
                                <div class="mb-3 col">
                                    <label for="surname" class="form-label">Cognoms</label>
                                    <input type="text" class="form-control" name="surname" id="surname"
                                        aria-describedby="helpId" placeholder="Cognoms de l'alumne"
                                        value="{{ request()->input('surname') }}">
                                </div>

                                <div class="mb-3 col">
                                    <label for="stage" class="form-label">Clase</label>
                                    <select class="form-select" name="stage" aria-label="Seleccionar etapa"
                                        id="stage">
                                        <option value="" selected>Selecciona etapa</option>
                                        @foreach (Auth::User()->getStageList() as $value)
                                            <option value="{{ $value }}"
                                                @if (request()->input('stage') == $value) {{ 'selected' }} @endif>

                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col">
                                    <label for="course" class="form-label">Curs</label>
                                    <select class="form-select" name="course" id="course">
                                        <option value="">Seleccionar curs</option>
                                        @for ($i = 1; $i <= 4; $i++)
                                            <option value="{{ $i }}"
                                                @if (request()->input('course') == $i) {{ 'selected' }} @endif>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3 col">
                                    <label for="group" class="form-label">Grup</label>
                                    <select class="form-select" name="group" id="group">
                                        <option value="">Seleccionar grup</option>
                                        @foreach (Auth::User()->getGroupList() as $value)
                                            <option value="{{ $value }}"
                                                @if (request()->input('group') == $value) {{ 'selected' }} @endif>

                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col">
                                    <label for="role" class="form-label">Rol</label>
                                    <select class="form-select" name="role" id="role">
                                        <option selected value="">Seleccionar Rol</option>
                                        <option {{ request()->input('role') == 'profesor' ? 'selected' : ' ' }}
                                            value="profesor">Profesor</option>
                                        <option {{ request()->input('role') == 'alumne' ? 'selected' : ' ' }}
                                            value="alumne">Alumne</option>
                                    </select>
                                </div>
                            </div>
                            <a href="{{ route('adminShowUsers') }}" class="btn btn-primary"><i
                                    class="bi bi-x-square"></i> Reset</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="my-3">

                {{ $users->links() }}
            </div>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Cognoms</th>
                        <th scope="col">Etapa</th>
                        <th scope="col">Curs</th>
                        <th scope="col">Grup</th>
                        <th scope="col">Primera eleccio</th>
                        <th scope="col">Segona eleccio</th>
                        <th scope="col">Tercera eleccio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('adminShowUser', $user->id) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->surname }}</td>
                            <td>
                                {{ $user->stage }}
                            </td>
                            <td>
                                {{ $user->course }}
                            </td>
                            <td>
                                {{ $user->group }}
                            </td>

                            @if (!$user->workshopChoices)
                                <td>No seleccionat</td>
                                <td>No seleccionat</td>
                                <td>No seleccionat</td>
                                @continue
                            @endif
                            @if ($user->workshopChoices->firstChoice)
                                <td>
                                    <a href="{{ route('showWorkshop', $user->workshopChoices->firstChoice->id) }}">
                                        {{ $user->workshopChoices->firstChoice->name }}
                                    </a>
                                </td>
                            @else
                                <td>No seleccionat</td>
                            @endif
                            @if ($user->workshopChoices->secondChoice)
                                <td>
                                    <a href="{{ route('showWorkshop', $user->workshopChoices->secondChoice->id) }}">
                                        {{ $user->workshopChoices->secondChoice->name }}
                                    </a>
                                </td>
                            @else
                                <td>No seleccionat</td>
                            @endif
                            @if ($user->workshopChoices->thirdChoice)
                                <td>
                                    <a href="{{ route('showWorkshop', $user->workshopChoices->thirdChoice->id) }}">
                                        {{ $user->workshopChoices->thirdChoice->name }}
                                    </a>
                                </td>
                            @else
                                <td>No seleccionat</td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
    @include('common.bootstrap-body')
    <script>
        var myCollapse = document.getElementById('filterCollapse')

        var bsCollapse = new bootstrap.Collapse(myCollapse, {
            toggle: false
        })
    </script>
</body>

</html>
