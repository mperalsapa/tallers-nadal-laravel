<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('common.bootstrap-header')
</head>

<body class="">
    <div class="border-secondary border container col-3 rounded py-3 my-5">
        <h1>Login</h1>
        <a class="d-flex justify-content-center align-items-center border btn btn-primary py-3 " href="{{ url(route('loginRedirect')) }}">
            <i class="bi bi-google"></i>
            <p class="m-0 ms-3">Google</p>
        </a>
        {{-- @isset(session("statusMessage")) --}}
        @if(session("statusMessage"))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session("statusMessage") }}
        </div>
        @endif
        {{-- @endisset --}}
    </div>
    @include('common.bootstrap-body')
</body>

</html>
