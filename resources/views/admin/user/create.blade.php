<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($user) ? 'Editar usuari' : 'Crear usuari' }}</title>


    @include('common.bootstrap-header')
    @include('common.custom-css')

</head>

<body>
    @include('admin.navbar')
    <div class="container pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('adminShowUsers') }}">Usuaris</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ isset($user) ? 'Editar usuari' : 'Crear usuari' }}</li>
            </ol>
        </nav>
        <h1>{{ isset($user) ? 'Editar usuari' : 'Crear usuari' }}</h1>


        <div class="d-flex gap-3 ">

            <form action="{{ route('adminStoreUser') }}" method="post" class="col-8">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger mt-3" role="alert">
                        <h3>S'han trobat els seguents errors</h3>
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Nom de l'alumne" value="{{ $user->name ?? old('name') }}">

                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Cognoms</label>
                    <input type="text" class="form-control" id="surname" name="surname"
                        placeholder="Cognom de l'alumne" value="{{ $user->surname ?? old('surname') }}">


                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Correu electrònic</label>
                    <input type="email" class="form-control" name="email" id=""
                        aria-describedby="emailHelpId" placeholder="Correu electrònic de l'alumne"
                        value="{{ $user->email ?? old('email') }}">

                </div>
                {{-- stage select list --}}
                <div class="mb-3">
                    <label for="stage" class="form-label">Etapa</label>
                    <select class="form-select" aria-label="Default select example" name="stage" id="stage">
                        <option value selected>Selecciona una etapa</option>
                        @foreach (Auth::User()->getStageList() as $value)
                            <option value="{{ $value }}"
                                @if (isset($user)) {{ $user->stage == $value ? 'selected' : '' }} @else {{ old('stage') == $value ? 'selected' : '' }} @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- select course --}}
                <div class="mb-3">
                    <label for="course" class="form-label">Curs</label>
                    <select class="form-select" aria-label="Default select example" name="course" id="course">
                        <option value selected>Selecciona un curs</option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}"
                                @if (isset($user)) {{ $user->course == $i ? 'selected' : '' }} @else {{ old('course') == $i ? 'selected' : '' }} @endif>
                                {{ $i }}

                            </option>
                        @endfor
                    </select>
                </div>
                {{-- select group --}}
                <div class="mb-3">
                    <label for="group" class="form-label">Grup</label>
                    <select class="form-select" aria-label="Default select example" name="group" id="group">
                        <option value selected>Selecciona un grup</option>
                        @foreach (Auth::User()->getGroupList() as $group)
                            <option value="{{ $group }}"
                                @if (isset($user)) {{ $user->group == $group ? 'selected' : '' }} @else {{ old('stage') == $group ? 'selected' : '' }} @endif>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3"
                    value="{{ isset($workshop->id) ? 'update' : 'new' }}"
                    name="submit">{!! isset($workshop->id) ? '<i class="bi bi-pencil"></i> Actualitzar' : '<i class="bi bi-save"></i> Guardar' !!}</button>
                @if (isset($workshop->id))
                    <button type="submit" class="btn btn-danger mt-3" value="delete" name="submit"><i
                            class="bi bi-trash"></i> Esborrar</button>
                @endif
            </form>
            <div class="col">
                <div class="d-flex flex-column bg-light rounded p-2">
                    <h2 class="text-center">Opcions</h2>
                    <form action="{{ route('adminRoutine') }}" method="POST">
                        @csrf
                        <button type="submit" name="submit" value="importUsers"
                            class="btn btn-primary mt-3 w-100">Recarregar
                            fitxer d'usuaris</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('common.bootstrap-body')
</body>

</html>
