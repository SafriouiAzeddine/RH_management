<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('accueil') }}"><i class="fas fa-home"></i> Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownActualites" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actualités
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownActualites">
                    <a class="dropdown-item" href="{{ route('news.events') }}">Événements</a>
                    <a class="dropdown-item" href="{{ route('news.journals') }}">Journaux</a>
                    <a class="dropdown-item" href="{{ route('news.weather') }}">Météo</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAbout" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    À propos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownAbout">
                    <a class="dropdown-item" href="{{ route('about.provinceRhamna') }}">Province Rhamna</a>
                    <a class="dropdown-item" href="{{ route('about.directeurRH') }}">Directeur RH</a>
                    <a class="dropdown-item" href="{{ route('about.divisionRH') }}">Division RH</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
            </li>
            @if (Route::has('login'))
                @auth
                    @if(Auth::user()->role == '1')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboardadmin') }}">Revenir à votre tableau de bord admin</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fonctionnaire.dashboard') }}">Retourner à votre tableau de bord fonctionnaire"</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
</nav>