@extends('Layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar bg-light p-3 shadow-sm">
                <h4 class="sidebar-title">Navigation</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-block">Liste des utilisateurs</a>
                    </li>
                    <!-- Delete User Form -->
                    <li class="list-group-item">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </li>
                    <!-- Add Recap Link -->
                    <li class="list-group-item">
                        <a href="{{ route('recapadd.edit', $user->id) }}" class="btn btn-warning btn-block">Ajouter Recape</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- User Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <!-- User Photo and Basic Information -->
                    <div class="d-flex align-items-start mb-4">
                        <!-- User Photo -->
                        <div class="mr-4" style="margin-right: 40px;">
                            @if($user->photo)
                                <img src="{{ asset('upload_files/photos/' . $user->photo) }}" alt="Photo de l'utilisateur" class="img-thumbnail" style="max-width: 150px;">
                            @else
                                <p class="text-muted">Pas de photo</p>
                            @endif
                        </div>
                        <!-- User Info -->
                        <div>
                            <h2 class="mb-2">{{ $user->prenomFr }} {{ $user->nomFr }}</h2>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Filière:</strong> {{ $user->filiere }}</p>
                            <p><strong>CINE:</strong> {{ $user->CINE }}</p>
                            <p><strong>Date de service:</strong> {{ $user->date_service }}</p>
                            <p><strong>Numéro PPR:</strong> {{ $user->numeroPPR }}</p>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Nom:</strong> {{ $user->nomFr }} {{ $user->nomAr }}</li>
                                <li class="list-group-item"><strong>Prénom:</strong> {{ $user->prenomFr }} {{ $user->prenomAr }}</li>
                                <li class="list-group-item"><strong>Nom du père (Français):</strong> {{ $user->nomPereFr }}</li>
                                <li class="list-group-item"><strong>Nom de la mère (Français):</strong> {{ $user->nomMereFr }}</li>
                                <li class="list-group-item"><strong>Lieu de naissance:</strong> {{ $user->lieu_naissance }}</li>
                                <li class="list-group-item"><strong>Date de naissance:</strong> {{ $user->date_naissance }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Date de grade:</strong> {{ $user->date_grade }}</li>
                                <li class="list-group-item"><strong>Date d'échelon:</strong> {{ $user->date_echellon }}</li>
                                <li class="list-group-item"><strong>Mission de responsabilité:</strong> {{ $user->mission_respo }}</li>
                                <li class="list-group-item"><strong>Local:</strong> {{ $user->local }}</li>
                                <li class="list-group-item"><strong>Mutuelle:</strong> {{ $user->mutuelle }}</li>
                                <li class="list-group-item"><strong>Solde de congé:</strong> {{ $user->solde_conger }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Children and Spouse Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3>Enfants</h3>
                            @if($user->enfants->isEmpty())
                                <p class="text-muted">Aucun enfant enregistré.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($user->enfants as $enfant)
                                        <li class="list-group-item">
                                            {{ $enfant->prenom_enfants }} {{ $enfant->nom_enfant }}<br>
                                            Date de naissance: {{ $enfant->date_naissance }}<br>
                                            Âge 16 ans: {{ $enfant->age16 ? 'Oui' : 'Non' }}<br>
                                            Scolaire: {{ $enfant->scolaire ? 'Oui' : 'Non' }}<br>
                                            Non scolaire: {{ $enfant->non_scolaire ? 'Oui' : 'Non' }}<br>
                                            Handicap: {{ $enfant->handicap ? 'Oui' : 'Non' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h3>Conjoints</h3>
                            @if($user->maries->isEmpty())
                                <p class="text-muted">Aucun conjoint enregistré.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($user->maries as $marie)
                                        <li class="list-group-item">
                                            {{ $marie->prenom }} {{ $marie->nom }}<br>
                                            Date de naissance: {{ $marie->date_naissance }}<br>
                                            Date de mariage: {{ $marie->date_mariage }}<br>
                                            Profession: {{ $marie->profession }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
