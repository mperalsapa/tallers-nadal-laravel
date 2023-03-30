<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sessió</title>
    @include('common.bootstrap-header')
</head>

<body class="">
    <div class="border-secondary border container col-3 rounded py-3 my-5">
        <h1>Iniciar sessió</h1>

        <a class="d-flex justify-content-center align-items-center border btn btn-primary py-3 "
            href="{{ url(route('loginRedirect')) }}">
            <i class="bi bi-google"></i>
            <p class="m-0 ms-3">Google</p>
        </a>

        {{-- @isset(session('statusMessage')) --}}
        @if (session('statusMessage'))
            <div class="alert alert-danger mt-3" role="alert">
                {{ session('statusMessage') }}
            </div>
        @endif
        {{-- @endisset --}}

        <div class="accordion mt-3" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        No tens compte del Sa Palomera?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Inicia sessió amb el teu compte del Sa Palomera. En cas de que encara no disposis d'un compte
                        amb l'adreça del Sa Palomera, contacta amb el teu tutor indicant que vols participar en els
                        tallers de nadal.
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('common.bootstrap-body')
</body>

</html>
