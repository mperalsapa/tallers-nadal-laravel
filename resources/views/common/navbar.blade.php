<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Tallers de nadal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{Route::is('index') ? 'active' : ''}}" aria-current="page" href="{{ route('index') }}">Inici</a>
                </li>
                @if (!Auth::User()->hasSelectWorkshopStarted() || Auth::User()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{Route::is('createWorkshop') ? 'active' : ''}}" aria-current="page" href="{{ route('createWorkshop') }}">
                        @if (Auth::User()->workshop && !Auth::User()->isAdmin())
                        Modificar Taller
                        @else
                        Crear Taller
                        @endif
                    </a>
                </li>
                @endif
                {{-- @if (!Auth::User()->isTeacher() && Auth::User()->hasSelectWorkshopStarted() && !Auth::User()->hasSelectWorkshopEnded())
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('selectWorkshops') }}">
                Escollir tallers
                </a>
                </li>
                @endif --}}
                @if (!Auth::User()->hasSelectWorkshopStarted() || Auth::User()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{Route::is('showWorkshopsHistory') ? 'active' : ''}}" aria-current="page" href="{{ route('showWorkshopsHistory') }}">
                        Historic de tallers
                    </a>
                </li>
                @endif

                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> --}}
            </ul>
            @include('common.navbar-user-dropdown')
        </div>
    </div>
</nav>
