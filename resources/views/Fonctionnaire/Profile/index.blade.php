@extends('layouts.layout') <!-- Remplacez 'app' par le nom de votre layout principal -->

@section('content')
<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
    <span class="mask bg-gradient-primary opacity-6"></span>
  </div>
  <!-- Profile Card -->
  <div class="card card-body mx-3 mx-md-4 mt-n6">
    <div class="row gx-4 mb-2">
      <!-- Profile Image -->
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="{{ asset('upload_files/photos/' . $user->photo) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div>
      <!-- Profile Info -->
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1">
            {{ $user->nomFr }} {{ $user->prenomFr }}
          </h5>
          <p class="mb-0 font-weight-normal text-sm">
            {{ $user->categoryFonctionnaire->nomFr }} / {{ $user->division->nomFr }}
          </p>
        </div>
      </div>
      <!-- Profile Actions -->
      <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
        <div class="nav-wrapper position-relative end-0">
          <ul class="nav nav-pills nav-fill p-1" role="tablist">
            <li class="nav-item">
              <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                <i class="material-icons text-lg position-relative">home</i>
                <span class="ms-1">App</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                <i class="material-icons text-lg position-relative">email</i>
                <span class="ms-1">Messages</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                <i class="material-icons text-lg position-relative">settings</i>
                <span class="ms-1">Settings</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Profile Details -->
    <div class="row">
      <!-- Profile Information -->
      <div class="col-12 col-xl-4">
          <div class="card h-100">
              <div class="card-header pb-0">
                  <h6>Profile Information</h6>
              </div>
              <div class="card-body">
                  <p class="text-sm">Bonjour, je suis {{ $user->nomFr }}. Voici quelques informations sur moi.</p>
                  <hr class="horizontal gray-light my-4">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom Complet EN FRANCAIS:</strong> &nbsp; {{ $user->nomFr . ' ' . $user->prenomFr }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom Complet EN ARABE:</strong> &nbsp; {{ $user->nomFr . ' ' . $user->prenomFr }}</li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">LIEU DE NAISSANCE:</strong> &nbsp; {{ $user->lieu_naissance }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">DATE DE NAISSANCE:</strong> &nbsp; {{ $user->date_naissance }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">CINE:</strong> &nbsp; {{ $user->CINE }}</li>
                  </ul>
              </div>
          </div>
      </div>
      
      <!-- Additional Info -->
      <div class="col-12 col-xl-4">
          <div class="card h-100">
              <div class="card-header pb-0">
                  <h6>Additional Information</h6>
              </div>
              <div class="card-body">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">STATUS DE FONCTIONNAIRE:</strong> &nbsp; {{ $user->statusFonctionnaire->status_fonctionnaire }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">MATRICULE:</strong> &nbsp; {{ $user->matricule->nemuro }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">DE Division:</strong> &nbsp; {{ $user->division->nomFr}}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">DE SERVICE:</strong> &nbsp; {{ $user->service->nomFr }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">GRADE:</strong> &nbsp; {{ $user->grade->nomFr }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">FILIERE:</strong> &nbsp; {{ $user->filiere }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Solde de Congé:</strong> &nbsp; {{ $user->solde_conger }}</li>
                  </ul>
              </div>
          </div>
      </div>
      
      <!-- Placeholder for Future Content -->
      <div class="col-12 col-xl-4">
          <div class="card h-100">
              <div class="card-header pb-0">
                  <h6>Section Placeholder</h6>
              </div>
              <div class="card-body">
                  <!-- Additional Content or Future Sections -->
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection




