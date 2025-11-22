@if(auth()->user()->role == '1') <!-- Assuming '1' represents admin RH role -->

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#">
      <img src="{{ asset('upload_files/logo_app/logo.png') }}" >
      <span class="ms-1 font-weight-bold text-white">APP RH</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white active bg-gradient-primary" href="{{ route('admin.dashboardadmin') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('listdemandes.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">list</i>
          </div>
          <span class="nav-link-text ms-1">Liste des Demandes</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#submenuUsers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuUsers">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">manage_accounts</i>
          </div>
          <span class="nav-link-text ms-1">Gérer Utilisateur</span>
        </a>
        <div class="collapse" id="submenuUsers">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('users.create') }}">
                <i class="material-icons me-2">person_add</i> Ajouter Utilisateur
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('users.index') }}">
                <i class="material-icons me-2">people</i> Liste des Utilisateurs
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('notifications.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">notifications</i>
          </div>
          <span class="nav-link-text ms-1">Notifications</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#submenuChat" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuChat">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">chat</i>
          </div>
          <span class="nav-link-text ms-1">DISCUSSION</span>
        </a>
        <div class="collapse" id="submenuChat">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('conversations.index') }}">
                <i class="material-icons me-2">lock</i> Discussion Privé
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('message.index') }}">
                <i class="material-icons me-2">people</i> Discussion Public
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('division.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">place</i>
          </div>
          <span class="nav-link-text ms-1">Divisions</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('service.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">local_offer</i>
          </div>
          <span class="nav-link-text ms-1">Services</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('profileadmin.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">logout</i>
          </div>
          <span class="nav-link-text ms-1">Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>
@elseif(auth()->user()->role == '0') <!-- Assuming '0' represents fonctionnaire role -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#">
      <img src="{{ asset('upload_files/logo_app/logo.png') }}" >
      <span class="ms-1 font-weight-bold text-white">APP RH</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white active bg-gradient-primary" href="{{ route('fonctionnaire.dashboard') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#submenuDemandes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuDemandes">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Demandes</span>
        </a>
        <div class="collapse" id="submenuDemandes">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('demandes.create') }}">
                <i class="material-icons me-2">note_add</i> Ajouter Demande
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('demandes.index') }}">
                <i class="material-icons me-2">list</i> Liste des Demandes
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('notifications.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">notifications</i>
          </div>
          <span class="nav-link-text ms-1">Notifications</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#submenuChat" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuChat">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">chat</i>
          </div>
          <span class="nav-link-text ms-1">DISCUSSION</span>
        </a>
        <div class="collapse" id="submenuChat">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('fonctionnaire.conversations.show') }}">
                <i class="material-icons me-2">lock</i> Discussion Privé
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('message.index') }}">
                <i class="material-icons me-2">public</i> Discussion Public
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('profile.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">logout</i>
          </div>
          <span class="nav-link-text ms-1">Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>
@endif
