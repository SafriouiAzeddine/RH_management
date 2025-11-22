@extends('Layouts.layout')

@section('content')
<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
    <span class="mask bg-gradient-primary opacity-6"></span>
  </div>
  <div class="card card-body mx-3 mx-md-4 mt-n6">
    <div class="row gx-4 mb-2">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="{{ asset('upload_files/photos/' . $user->photo) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1">
            {{ $user->nomFr . ' ' . $user->prenomFr }}
          </h5>
          <p class="mb-0 font-weight-normal text-sm">
            Division: {{ $user->division }}
          </p>
        </div>
      </div>
    </div>
    
    <!-- Messages d'erreur et de confirmation -->
    @if (session('message'))
      <div class="alert alert-{{ session('alertType') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <div class="row">
      <div class="col-12 col-xl-4">
        <div class="card card-plain h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-md-8 d-flex align-items-center">
                <h6 class="mb-0">Informations du Profil</h6>
              </div>
              <div class="col-md-4 text-end">
                <a href="javascript:;">
                  <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier le profil"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="card-body p-3">
            <p class="text-sm">
              Bonjour, je suis {{ $user->nomFr }}. Voici quelques informations sur moi.
            </p>
            <hr class="horizontal gray-light my-4">
            <ul class="list-group">
              <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom Complet:</strong> &nbsp; {{ $user->nomFr . ' ' . $user->prenomFr }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{ $user->email }}</li>
              <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Solde de Congé:</strong> &nbsp; {{ $user->solde_conger }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12 col-xl-4">
        <div class="card card-plain h-100">
          <div class="card-header pb-0 p-3">
            <h6 class="mb-0">Actions</h6>
          </div>
          <div class="card-body p-3">
            <form action="{{ route('listdemandes.update', $demande->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="accepté">
              <button type="submit" class="btn btn-success w-100 mb-2">Accepté</button>
            </form>
            <form action="{{ route('listdemandes.update', $demande->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="refusé">
              <button type="submit" class="btn btn-danger w-100">Refusé</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
