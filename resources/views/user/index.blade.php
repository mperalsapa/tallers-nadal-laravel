<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tallers de Nadal</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container">
        <h1>Hola {{ Auth::user()->name }}, tens rol de {{ Auth::user()->authority }}</h1>
        <h2>Pertanys al curs {{ Auth::user()->courseName() }}</h2>
        @if (Auth::user()->isTeacher())
            <h3>Ets professor!!</h3>
        @else
            <h3>No ets professor :(</h3>
        @endif
        {{ dd(Auth::user()->workshop()->get()) }}

    </div>
    @include('common.bootstrap-body')
</body>

</html>
