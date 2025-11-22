@extends('Layouts.layout')

@section('content')
<div class="container">
    <h1>Modifier l'utilisateur</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body mb-3">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nom et Prénom -->
            <div class="form-group">
                <label for="nomFr">Nom (Français)</label>
                <input type="text" name="nomFr" id="nomFr" class="form-control" value="{{ old('nomFr', $user->nomFr) }}" required>
            </div>

            <div class="form-group">
                <label for="nomAr">Nom (Arabe)</label>
                <input type="text" name="nomAr" id="nomAr" class="form-control" value="{{ old('nomAr', $user->nomAr) }}" required>
            </div>

            <div class="form-group">
                <label for="prenomFr">Prénom (Français)</label>
                <input type="text" name="prenomFr" id="prenomFr" class="form-control" value="{{ old('prenomFr', $user->prenomFr) }}" required>
            </div>

            <div class="form-group">
                <label for="prenomAr">Prénom (Arabe)</label>
                <input type="text" name="prenomAr" id="prenomAr" class="form-control" value="{{ old('prenomAr', $user->prenomAr) }}" required>
            </div>

            <!-- Nom du père et de la mère -->
            <div class="form-group">
                <label for="nomPereFr">Nom du père (Français)</label>
                <input type="text" name="nomPereFr" id="nomPereFr" class="form-control" value="{{ old('nomPereFr', $user->nomPereFr) }}">
            </div>

            <div class="form-group">
                <label for="nomPereAr">Nom du père (Arabe)</label>
                <input type="text" name="nomPereAr" id="nomPereAr" class="form-control" value="{{ old('nomPereAr', $user->nomPereAr) }}">
            </div>

            <div class="form-group">
                <label for="nomMereFr">Nom de la mère (Français)</label>
                <input type="text" name="nomMereFr" id="nomMereFr" class="form-control" value="{{ old('nomMereFr', $user->nomMereFr) }}">
            </div>

            <div class="form-group">
                <label for="nomMereAr">Nom de la mère (Arabe)</label>
                <input type="text" name="nomMereAr" id="nomMereAr" class="form-control" value="{{ old('nomMereAr', $user->nomMereAr) }}">
            </div>

            <!-- Lieu et Date de naissance -->
            <div class="form-group">
                <label for="lieu_naissance">Lieu de naissance</label>
                <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control" value="{{ old('lieu_naissance', $user->lieu_naissance) }}">
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" name="date_naissance" id="date_naissance" class="form-control" value="{{ old('date_naissance', $user->date_naissance) }}">
            </div>

            <!-- CINE et Email -->
            <div class="form-group">
                <label for="CINE">CINE</label>
                <input type="text" name="CINE" id="CINE" class="form-control" value="{{ old('CINE', $user->CINE) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe </label>
                <input type="password" name="password" id="password" class="form-control" value="{{ old('password', $user->password) }}">
            </div>
            <!-- Category -->
            <div class="form-group">
                <label for="category_fonctionnaire_id">Category Fonctionnaire</label>
                <select name="category_fonctionnaire_id" id="category_fonctionnaire_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nomFr }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Matricule, Grade, Division, Service, Status -->
            <div class="form-group">
                <label for="id_matricule">Matricule</label>
                <select name="id_matricule" id="id_matricule" class="form-control" required>
                    @foreach($matricules as $matricule)
                        <option value="{{ $matricule->id }}" {{ $user->id_matricule == $matricule->id ? 'selected' : '' }}>
                            {{ $matricule->numero }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_grade">Grade</label>
                <select name="id_grade" id="id_grade" class="form-control" required>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $user->id_grade == $grade->id ? 'selected' : '' }}>
                            {{ $grade->nomFr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_division">Division</label>
                <select name="id_division" id="id_division" class="form-control" required>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ $user->id_division == $division->id ? 'selected' : '' }}>
                            {{ $division->nomAr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_service">Service</label>
                <select name="id_service" id="id_service" class="form-control" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $user->id_service == $service->id ? 'selected' : '' }}>
                            {{ $service->nomFr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_status">Status</label>
                <select name="id_status" id="id_status" class="form-control" required>
                    @foreach($status as $stat)
                        <option value="{{ $stat->id }}" {{ $user->id_status == $stat->id ? 'selected' : '' }}>
                            {{ $stat->status_fonctionnaire  }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filière, CNOPS, Date de service, Numéro PPR, Date de grade, Date d'échelon -->
            <div class="form-group">
                <label for="filiere">Filière</label>
                <input type="text" name="filiere" id="filiere" class="form-control" value="{{ old('filiere', $user->filiere) }}">
            </div>

            <div class="form-group">
                <label for="CNOPS">CNOPS</label>
                <input type="text" name="CNOPS" id="CNOPS" class="form-control" value="{{ old('CNOPS', $user->CNOPS) }}">
            </div>

            <div class="form-group">
                <label for="date_service">Date de service</label>
                <input type="date" name="date_service" id="date_service" class="form-control" value="{{ old('date_service', $user->date_service) }}">
            </div>

            <div class="form-group">
                <label for="numeroPPR">Numéro PPR</label>
                <input type="text" name="numeroPPR" id="numeroPPR" class="form-control" value="{{ old('numeroPPR', $user->numeroPPR) }}">
            </div>

            <div class="form-group">
                <label for="date_grade">Date de grade</label>
                <input type="date" name="date_grade" id="date_grade" class="form-control" value="{{ old('date_grade', $user->date_grade) }}">
            </div>

            <div class="form-group">
                <label for="date_echellon">Date d'échellon</label>
                <input type="date" name="date_echellon" id="date_echellon" class="form-control" value="{{ old('date_echellon', $user->date_echellon) }}">
            </div>

            <div class="form-group">
                <label for="mission_respo">Mission de responsabilité</label>
                <input type="text" name="mission_respo" id="mission_respo" class="form-control" value="{{ old('mission_respo', $user->mission_respo) }}">
            </div>

            <div class="form-group">
                <label for="local">Local</label>
                <input type="text" name="local" id="local" class="form-control" value="{{ old('local', $user->local) }}">
            </div>

            <div class="form-group">
                <label for="mutuelle">Mutuelle</label>
                <input type="text" name="mutuelle" id="mutuelle" class="form-control" value="{{ old('mutuelle', $user->mutuelle) }}">
            </div>

            <div class="form-group">
                <label for="solde_conger">Solde de congé</label>
                <input type="text" name="solde_conger" id="solde_conger" class="form-control" value="{{ old('solde_conger', $user->solde_conger) }}">
            </div>

            <!-- Photo -->
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                @if($user->photo)
                    <img src="{{ asset('upload_files/photos/' . $photoName) }}" alt="Photo de l'utilisateur" class="img-fluid mt-2" style="max-width: 150px;">
                @endif
            </div>

            <!-- Enfants -->
            <h3>Enfants</h3>
            @forelse($user->enfants as $enfant)
                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][nom_enfant]">Nom de l'enfant</label>
                    <input type="text" name="enfants[{{ $loop->index }}][nom_enfant]" id="enfants[{{ $loop->index }}][nom_enfant]" class="form-control" value="{{ old('enfants['.$loop->index.'][nom_enfant]', $enfant->nom_enfant) }}">
                </div>

                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][date_naissance]">Date de naissance</label>
                    <input type="date" name="enfants[{{ $loop->index }}][date_naissance]" id="enfants[{{ $loop->index }}][date_naissance]" class="form-control" value="{{ old('enfants['.$loop->index.'][date_naissance]', $enfant->date_naissance) }}">
                </div>

                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][age16]">Âge 16 ans</label>
                    <select name="enfants[{{ $loop->index }}][age16]" id="enfants[{{ $loop->index }}][age16]" class="form-control">
                        <option value="1" {{ old('enfants['.$loop->index.'][age16]', $enfant->age16) ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ !old('enfants['.$loop->index.'][age16]', $enfant->age16) ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][scolaire]">Scolaire</label>
                    <select name="enfants[{{ $loop->index }}][scolaire]" id="enfants[{{ $loop->index }}][scolaire]" class="form-control">
                        <option value="1" {{ old('enfants['.$loop->index.'][scolaire]', $enfant->scolaire) ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ !old('enfants['.$loop->index.'][scolaire]', $enfant->scolaire) ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][handicap]">Handicap</label>
                    <select name="enfants[{{ $loop->index }}][handicap]" id="enfants[{{ $loop->index }}][handicap]" class="form-control">
                        <option value="1" {{ old('enfants['.$loop->index.'][handicap]', $enfant->handicap) ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ !old('enfants['.$loop->index.'][handicap]', $enfant->handicap) ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="enfants[{{ $loop->index }}][prenom_enfant]">Prénom de l'enfant</label>
                    <input type="text" name="enfants[{{ $loop->index }}][prenom_enfant]" id="enfants[{{ $loop->index }}][prenom_enfant]" class="form-control" value="{{ old('enfants['.$loop->index.'][prenom_enfant]', $enfant->prenom_enfant) }}">
                </div>
            @empty
                <p>Aucun enfant enregistré.</p>
            @endforelse

            <!-- Conjoints -->
            <h3>Conjoints</h3>
            @forelse($user->maries as $marie)
                <div class="form-group">
                    <label for="maries[{{ $loop->index }}][nom]">Nom du conjoint</label>
                    <input type="text" name="maries[{{ $loop->index }}][nom]" id="maries[{{ $loop->index }}][nom]" class="form-control" value="{{ old('maries['.$loop->index.'][nom]', $marie->nom) }}">
                </div>

                <div class="form-group">
                    <label for="maries[{{ $loop->index }}][prenom]">Prénom du conjoint</label>
                    <input type="text" name="maries[{{ $loop->index }}][prenom]" id="maries[{{ $loop->index }}][prenom]" class="form-control" value="{{ old('maries['.$loop->index.'][prenom]', $marie->prenom) }}">
                </div>

                <div class="form-group">
                    <label for="maries[{{ $loop->index }}][date_naissance]">Date de naissance</label>
                    <input type="date" name="maries[{{ $loop->index }}][date_naissance]" id="maries[{{ $loop->index }}][date_naissance]" class="form-control" value="{{ old('maries['.$loop->index.'][date_naissance]', $marie->date_naissance) }}">
                </div>

                <div class="form-group">
                    <label for="maries[{{ $loop->index }}][date_mariage]">Date de mariage</label>
                    <input type="date" name="maries[{{ $loop->index }}][date_mariage]" id="maries[{{ $loop->index }}][date_mariage]" class="form-control" value="{{ old('maries['.$loop->index.'][date_mariage]', $marie->date_mariage) }}">
                </div>

                <div class="form-group">
                    <label for="maries[{{ $loop->index }}][profession]">Profession</label>
                    <input type="text" name="maries[{{ $loop->index }}][profession]" id="maries[{{ $loop->index }}][profession]" class="form-control" value="{{ old('maries['.$loop->index.'][profession]', $marie->profession) }}">
                </div>
            @empty
                <p>Aucun conjoint enregistré.</p>
            @endforelse

            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Enregistrer</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary" style="margin-top: 20px;">Annuler</a>
        </form>
    </div>
</div>
@endsection