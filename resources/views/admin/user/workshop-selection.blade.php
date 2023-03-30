<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assignacio manual de tallers</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container my-3">
        @php
            $isSelectWorkshopPeriod = Auth::User()->isSelectWorkshopPeriod();
        @endphp

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('adminShowUsers') }}">Usuaris</a></li>
                <li class="breadcrumb-item"><a href="{{ route('adminShowUser', $user->id) }}">
                        {{ $user->name . ' ' . $user->surname }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assignacio manual</li>
            </ol>
        </nav>
        <form action="{{ route('adminSelectWorkshop', $user->id) }}" method="GET" class="">
            @csrf
            <input type="hidden" name="workshopChoiceType" value="{{ $workshopChoiceType }}">
            <div class="row">
                <h2>Taller</h2>
                <div class="mb-3 col">
                    <label for="w_name" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="w_name" id="w_name" aria-describedby="helpId"
                        placeholder="Nom del taller" value="{{ request()->input('w_name') }}">
                </div>
                <div class="mb-3 col">
                    <label for="w_description" class="form-label">Descripcio</label>
                    <input type="text" class="form-control" name="w_description" id="w_description"
                        aria-describedby="helpId" placeholder="Descripcio del taller"
                        value="{{ request()->input('w_description') }}">
                </div>
                <div class="mb-3 col">
                    <label for="w_stage" class="form-label">Etapa</label>
                    <select class="form-select" name="w_stage" aria-label="Seleccionar etapa" id="w_stage">
                        <option value="" selected>Selecciona etapa</option>
                        @foreach (Auth::User()->getStageList() as $value)
                            <option value="{{ $value }}"
                                @if (request()->input('w_stage') == $value) {{ 'selected' }} @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="w_course" class="form-label">Curs</label>
                    <select class="form-select" name="w_course" id="w_course">
                        <option value="">Seleccionar curs</option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}"
                                @if (request()->input('w_course') == $i) {{ 'selected' }} @endif>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="row">
                <h2>Usuari</h2>
                <div class="mb-3 col">
                    <label for="u_name" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="u_name" id="u_name" aria-describedby="helpId"
                        placeholder="Nom de l'alumne" value="{{ request()->input('u_name') }}">
                </div>
                <div class="mb-3 col">
                    <label for="u_surname" class="form-label">Cognoms</label>
                    <input type="text" class="form-control" name="u_surname" id="u_surname" aria-describedby="helpId"
                        placeholder="Cognoms de l'alumne" value="{{ request()->input('u_surname') }}">
                </div>

                <div class="mb-3 col">
                    <label for="u_stage" class="form-label">Clase</label>
                    <select class="form-select" name="u_stage" aria-label="Seleccionar etapa" id="u_stage">
                        <option value="" selected>Selecciona etapa</option>
                        @foreach (Auth::User()->getStageList() as $value)
                            <option value="{{ $value }}"
                                @if (request()->input('u_stage') == $value) {{ 'selected' }} @endif>

                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="u_course" class="form-label">Curs</label>
                    <select class="form-select" name="u_course" id="u_course">
                        <option value="">Seleccionar curs</option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}"
                                @if (request()->input('u_course') == $i) {{ 'selected' }} @endif>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="u_group" class="form-label">Grup</label>
                    <select class="form-select" name="u_group" id="u_group">
                        <option value="">Seleccionar grup</option>
                        @foreach (Auth::User()->getGroupList() as $value)
                            <option value="{{ $value }}"
                                @if (request()->input('u_group') == $value) {{ 'selected' }} @endif>

                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="u_role" class="form-label">Rol</label>
                    <select class="form-select" name="u_role" id="u_role">
                        <option selected value="">Seleccionar Rol</option>
                        <option {{ request()->input('u_role') == 'profesor' ? 'selected' : ' ' }} value="profesor">
                            Profesor</option>
                        <option {{ request()->input('u_role') == 'alumne' ? 'selected' : ' ' }} value="alumne">
                            Alumne
                        </option>
                    </select>
                </div>
            </div>

            <a href="{{ route('adminSelectWorkshop', ['id' => $user->id, 'workshopChoiceType' => $workshopChoiceType]) }}"
                class="btn btn-primary"><i class="bi bi-x-square"></i> Reset</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
        </form>
        <div class="mt-3">

            {{ $workshops->links() }}
        </div>
        <table class="table mt-3 mb-5">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Descripcio</th>
                    <th scope="col">Adreçat a</th>
                    <th scope="col">Accio</th>
                    @if ($isSelectWorkshopPeriod)
                        <th scope="col">Places</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($workshops as $workshop)
                    <tr>
                        <td>
                            <a class="" href="{{ route('showWorkshop', $workshop->id) }}">
                                {{ $workshop->name }}
                            </a>
                        </td>
                        <td>{{ $workshop->description }}</td>
                        <td>
                            @foreach ($workshop->addressed_to as $course)
                                <span class="badge bg-primary">{{ Auth::User()->getCourseList()[$course] }}</span>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('adminStoreWorkshopSelection', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="workshopId" value="{{ $workshop->id }}">
                                <input type="hidden" name="workshopChoiceType" value="{{ $workshopChoiceType }}">
                                <button type="submit" class="btn btn-primary">Seleccionar</button>
                            </form>
                        </td>
                        @if ($isSelectWorkshopPeriod)
                            <td>
                                {{ sprintf('%02d', $workshop->getFreeStudents()) . '/' . sprintf('%02d', $workshop->max_students) }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $workshops->links() }}
    </div>
    @include('common.bootstrap-body')
</body>

</html>
