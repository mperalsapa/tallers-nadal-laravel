<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuari {{ $user->name . ' ' . $user->surname }}</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container mt-5">
        <div class="d-flex gap-2">
            <div class="col-8">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('adminShowUsers') }}">Usuaris</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $user->name . ' ' . $user->surname }}</li>
                        </ol>
                    </nav>
                    <h1>Gestió d'usuaris</h1>

                    <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                    <h3>{{ $user->fullCourseName() }}</h3>
                    <h3>
                        @if (!$user->isTeacher())
                            {{ $user->role }}
                        @else
                            {{ $user->role . ' - ' . $user->authority }}
                        @endif
                    </h3>
                </div>
                @if (!$user->isAdmin())
                    <form action="{{ route('adminSelectWorkshop', $user->id) }}" method="get">

                        <table class=" table mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">Primera opcio</th>
                                    <th scope="col">Segona opcio</th>
                                    <th scope="col">Tercera opcio</th>

                                    <th scope="col">Assignat</th>
                                </tr>
                            </thead>


                            @if (optional($user->workshopChoices)->firstChoice)
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="0"
                                        class="badge bg-primary border-0"><i class="bi bi-pencil"></i></button>

                                    <a
                                        href="{{ route('showWorkshop', $user->workshopChoices->firstChoice->id) }}">{{ $user->workshopChoices->firstChoice->name }}</a>

                                </td>
                            @else
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="0"
                                        class="btn btn-primary">Seleccionar</button>
                                </td>
                            @endif
                            @if (optional($user->workshopChoices)->secondChoice)
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="1"
                                        class="badge bg-primary border-0"><i class="bi bi-pencil"></i></button>
                                    <a
                                        href="{{ route('showWorkshop', $user->workshopChoices->secondChoice->id) }}">{{ $user->workshopChoices->secondChoice->name }}</a>
                                </td>
                            @else
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="1"
                                        class="btn btn-primary">Seleccionar</button>
                                </td>
                            @endif
                            @if (optional($user->workshopChoices)->thirdChoice)
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="2"
                                        class="badge bg-primary border-0"><i class="bi bi-pencil"></i></button>
                                    <a
                                        href="{{ route('showWorkshop', $user->workshopChoices->thirdChoice->id) }}">{{ $user->workshopChoices->thirdChoice->name }}</a>
                                </td>
                            @else
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="2"
                                        class="btn btn-primary">Seleccionar</button>
                                </td>
                            @endif
                            @if (optional($user->workshopChoices)->assigned)
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="3"
                                        class="badge bg-primary border-0"><i class="bi bi-pencil"></i></button>
                                    <a
                                        href="{{ route('showWorkshop', $user->workshopChoices->assigned->id) }}">{{ $user->workshopChoices->assigned->name }}</a>
                                </td>
                            @else
                                <td class="align-middle">
                                    <button type="submit" name="workshopChoiceType" value="3"
                                        class="btn btn-primary">Seleccionar</button>
                                </td>
                            @endif

                        </table>
                    </form>

                @endif
            </div>

            <div class="col">
                <div class="col d-flex flex-column bg-light rounded p-2">
                    <h2 class="text-center">Administració</h2>
                    <a class="btn btn-primary mt-3" href="{{ route('adminEditUser', $user->id) }}">Editar</a>
                    @if (Auth::User()->isSuperAdmin() && !$user->isSuperAdmin())

                        <form action="{{ route('adminUpdateUserRole', $user->id) }}" method="POST" class="mt-3">
                            {{-- <form action="" method="POST"> --}}
                            @csrf
                            @if ($user->isTeacher())
                                <button type="submit" name="action" value="makeStudent"
                                    class="btn btn-primary w-100 mb-3">Treure professor</button>
                                @if ($user->isAdmin())
                                    <button type="submit" name="action" value="removeAdmin"
                                        class="btn btn-primary w-100 mb-3">Treure administrador</button>
                                @else
                                    <button type="submit" name="action" value="makeAdmin"
                                        class="btn btn-primary w-100 mb-3">Fer Administrador</button>
                                @endif
                            @else
                                <button type="submit" name="action" value="makeTeacher"
                                    class="btn btn-primary w-100 mb-3">Fer professor</button>
                            @endif
                        </form>
                        <form action="{{ route('adminDeleteUser', $user->id) }}" method="post" class="mt-3">
                            @csrf
                            <input type="hidden" name="userId" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger w-100">Esborrar</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('common.bootstrap-body')

</body>

</html>
