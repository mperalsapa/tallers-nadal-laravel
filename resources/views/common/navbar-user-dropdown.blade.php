<ul class="navbar-nav mb-2 mb-lg-0">
    <li class="nav-item dropstart">
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="{{route("logout")}}">Tancar sessió</a></li>
            @if(Auth::user()->isAdmin())
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>

                <a class="dropdown-item" href="{{route("adminDashboardIndex")}}">Administració</a>

            </li>
            @endif

            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </li>
</ul>
