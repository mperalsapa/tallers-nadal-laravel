<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registre d'events</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('adminDashboardIndex') }}">Administracio</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Registre d'events</li>
            </ol>
        </nav>
        <h1>Registre d'events</h1>
        {{-- print if session has error --}}
        @if (session()->get('error'))
            <div class="alert alert-danger mt-3" role="alert">
                <strong>ERROR: </strong> {{ session()->get('error') }}
            </div>
            {{ session()->forget('error') }}
        @endif
        {{-- create a "console like" container to display log messages --}}
        <div class="container-fluid border border-dark" style="height: 70vh; overflow-y: scroll;">
            @foreach ($actionLog as $line)
                <p>{{ $line }}</p>
            @endforeach
        </div>

    </div>
    @include('common.bootstrap-body')

</body>

</html>
