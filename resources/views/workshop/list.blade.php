<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Llista de tallers</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container my-5">
        @php
            $isSelectWorkshopPeriod = Auth::User()->isSelectWorkshopPeriod();
        @endphp
        @if ($isSelectWorkshopPeriod)
            <div class="alert alert-success mt-3" role="alert">
                <strong>Fes la teva seleccio!</strong> Ja pots seleccionar els tallers en els que vols participar, fes
                les teves seleccions!
            </div>
        @elseif (Auth::User()->hasSelectWorkshopEnded())
            <div class="alert alert-danger mt-3" role="alert">
                <strong>S'ha acabat el temps!</strong> S'ha acabat el temps per realitzar les seleccions de tallers.
            </div>
        @endif
        @if (session()->get('error'))
            <div class="alert alert-danger mt-3" role="alert">
                <strong>ERROR: </strong> {{ session()->get('error') }}
            </div>
            {{ session()->forget('error') }}
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Tallers</li>
            </ol>
        </nav>
        <table class="table mt-3 mb-5">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Descripcio</th>
                    <th scope="col">Adreçat a</th>
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
                            @if (Auth::User()->isTeacher())
                                @foreach ($workshop->addressed_to as $course)
                                    <a class="badge bg-primary"
                                        href="{{ request()->fullUrlWithQuery(['addressedTo' => $course]) }}">
                                        {{ Auth::User()->getCourseList()[$course] }}
                                    </a>
                                @endforeach
                            @else
                                @foreach ($workshop->addressed_to as $course)
                                    <span class="badge bg-primary">
                                        {{ Auth::User()->getCourseList()[$course] }}
                                    </span>
                                @endforeach
                            @endif
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
