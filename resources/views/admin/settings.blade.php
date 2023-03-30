<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opcions del lloc</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container my-5">
        @if (session()->get('error'))
            <div class="alert alert-danger mt-3" role="alert">
                <strong>ERROR: </strong> {{ session()->get('error') }}
            </div>
            {{ session()->forget('error') }}
        @endif
        @if (session()->get('success'))
            <div class="alert alert-success mt-3" role="alert">
                {{ session()->get('success') }}
            </div>
            {{ session()->forget('success') }}
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Opcions</li>
            </ol>
        </nav>
        <h1>Opcions</h1>
        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger mt-3" role="alert">
                    <h3>S'han trobat els seguents errors</h3>
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            @endif

            <form action="{{ route('adminStoreSetting') }}" method="post">
                @csrf
                <div>

                    <h2>Dates de seleccio de tallers</h2>
                    <p>La data inicial es el moment en el que l'alumnat pot escollir els tres tallers, i no poden
                        crear-ne de nous.</p>
                    <p>La data final es el moment en el que ja no es poden escollir tallers i es realitza la seleccio de
                        taller per cada alumne</p>
                    <label for="startingDate">
                        Data inicial
                        <input class="form-control" type="datetime-local" name="startingDate" id="startingDate"
                            {{ isset($workshopStartDate) ? 'value=' . $workshopStartDate : '' }}>
                    </label>
                    @csrf
                    <label for="endingDate">
                        Data final
                        <input class="form-control" type="datetime-local" name="endingDate" id="endingDate"
                            {{ isset($workshopEndDate) ? 'value=' . $workshopEndDate : '' }}>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mt-3" name="submit" value="select_end_date">
                    <i class="bi bi-save"></i> Guardar</button>
            </form>
            <hr>
            <form action="{{ route('adminRoutine') }}" method="POST">
                @csrf
                @if (!$checkedUserAsignedWorkshops)
                    <h2>Generar asignacio de tallers</h2>
                    <div class="my-3">
                        <p>Genera la assignacio de tallers per cada usuari. Aquesta accio requereix que cada alumne
                            tingui 3
                            seleccions de taller.</p>
                        <button type="submit" name="submit" value="assignWorkshopUsers"
                            class="btn btn-primary">Generar</button>
                    </div>
                    <div class="my-3">
                        <p>Forçar la generacio seleccions de tallers pels usuaris que no ho han fet.</p>
                        <button type="submit" name="submit" value="forceAssignWorkshopUsers"
                            class="btn btn-danger">Forçar
                            assignacions</button>
                    </div>
                @else
                    <h2>Generacio d'informes</h2>
                    <div class="d-flex gap-3">
                        <div>
                            <h3>Alumnes per taller</h3>
                            <p>Genera un fitxer CSV amb la llista d'alumnes per taller.</p>
                            <button type="submit" name="submit" value="generateWorkshopUsersReport"
                                class="btn btn-primary">Generar</button>
                        </div>
                        <div>
                            <h3>Material per taller</h3>
                            <p>Genera un fitxer CSV amb la llista de material per taller.</p>
                            <button type="submit" name="submit" value="generateWorkshopsMaterialsReport"
                                class="btn btn-primary">Generar</button>
                        </div>
                        <div>
                            <h3>Assignació de cada alumne</h3>
                            <p>Genera un fitxer CSV amb la llista de tallers per alumne.</p>
                            <button type="submit" name="submit" value="generateWorkshopChoiceReport"
                                class="btn btn-primary">Generar</button>
                        </div>
                    </div>

            </form>
            <hr>
            <form action="{{ route('adminRoutine') }}" method="post">
                @csrf
                <div>
                    <h2>Netejar seleccions / assignacions</h2>
                    <div class="my-3">
                        <p>
                            En cas de que es vulgui esborrar les seleccions o assignacions de tallers per usuari, es pot
                            fer
                            servir aquesta opcio.
                        </p>
                        <button type="submit" name="submit" value="clearChosedWorkshops"
                            class="btn btn-danger">Netejar
                            seleccions</button>
                    </div>
                    <div class="my-3">
                        <p>Tingues en compte, que si vols netejar les eleccions i no tots els usuaris tenen una
                            assignacio,
                            la propera vegada que vulguis assignar massivament, s'auto afegiran eleccions als usuaris.
                        </p>
                        <button type="submit" name="submit" value="clearAssignedWorkshops"
                            class="btn btn-danger">Netejar
                            asignacions</button>
                    </div>
                </div>
            </form>
            @endif
            <hr>
            <form action="{{ route('adminRoutine') }}" method="post">
                @csrf
                <h2>Moure tallers a l'historic</h2>
                <p>Moure els tallers d'aquest any ({{ date('Y') }}) a l'historic de tallers. Aquesta accio es
                    irreversible.</p>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#moveWorkshopsModal">
                    Moure
                </button>
                <!-- Modal -->
                <div class="modal fade" id="moveWorkshopsModal" tabindex="-1" aria-labelledby="moveWorkshopsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="moveWorkshopsModalLabel">Moure Tallers</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Aquesta accio es irreversible, i en cas de no haver acabat el proces dels tallers i
                                generats els informes, no será possible fer-ho mes endevant. Si no saps el que estas
                                fent, no ho facis.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" value="storeWorkshops"
                                    class="btn btn-danger">Moure</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <hr>
            <div class="d-flex gap-3">
                <form action="{{ route('adminRoutine') }}" method="POST">
                    @csrf
                    <h2>Importar usuaris</h2>
                    <p>Impmorta usuaris del fitxer emmagatzemat en el servidor. Aquesta accio afegeix o actualitza
                        usuaris.</p>

                    <button type="submit" name="submit" value="importUsers"
                        class="btn btn-primary">Importar</button>
                </form>
                <form action="{{ route('adminRoutine') }}" method="post">
                    @csrf
                    <h2>Esborrar usuaris</h2>
                    <p>Esborrar tots els usuaris (excepte Super Administradors) de la base de dades.</p>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#clearUsersModal">
                        Esborrar
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="clearUsersModal" tabindex="-1"
                        aria-labelledby="clearUsersModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="clearUsersModalLabel">Esborrar Usuaris</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Aquesta accio es irreversible, i en cas de no haver acabat el proces dels tallers i
                                    generats els informes, no será possible fer-ho mes endevant. Si no saps el que estas
                                    fent, no ho facis.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" value="clearUsers"
                                        class="btn btn-danger">Esborrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
    @include('common.bootstrap-body')
</body>

</html>
