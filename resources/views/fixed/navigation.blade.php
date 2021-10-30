<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('home')}}">Fakture</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('clients.index')}}">Klijenti</a>
                    </li>
                    <li class="nav-item ms-auto">
                        <p class="nav-link mb-0">Welcome, {{ auth()->user()->full_company_name }}</p>
                    </li>
                    <li class="nav-item ms-1 d-flex align-items-center">
                        <a class="nav-link" aria-current="page" href="{{route('logout')}}">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
