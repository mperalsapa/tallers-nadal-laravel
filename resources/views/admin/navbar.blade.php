<nav class="navbar navbar-expand-lg navbar-light bg-light d-print-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Tallers de Nadal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('index') }}">Inici</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::is('adminDashboardIndex') ? 'active' : ''}}" aria-current="page" href="{{ route('adminDashboardIndex') }}">Panell</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Usuaris
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('adminShowUsers') }}">Listat</a></li>
                        <li><a class="dropdown-item" href="{{ route("adminCreateUser") }}">Crear Usuari</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::is('adminShowSetting') ? 'active' : ''}}" href="{{ route('adminShowSetting') }}">Configuracio</a>
                </li>
            </ul>
            @include('common.navbar-user-dropdown')
        </div>
    </div>
</nav>
