@extends('layouts.layout')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background-color: #007bff; color: white;">Ajouter un utilisateur</div>
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
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nom en Français -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomFr">Nom (Français)</label>
                            <input type="text" name="nomFr" id="nomFr" class="form-control" required>
                        </div>

                        <!-- Nom en Arabe -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomAr">Nom (Arabe)</label>
                            <input type="text" name="nomAr" id="nomAr" class="form-control" required>
                        </div>

                        <!-- Prénom en Français -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="prenomFr">Prénom (Français)</label>
                            <input type="text" name="prenomFr" id="prenomFr" class="form-control" required>
                        </div>

                        <!-- Prénom en Arabe -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="prenomAr">Prénom (Arabe)</label>
                            <input type="text" name="prenomAr" id="prenomAr" class="form-control" required>
                        </div>

                        <!-- Nom du Père en Français -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomPereFr">Nom du Père (Français)</label>
                            <input type="text" name="nomPereFr" id="nomPereFr" class="form-control">
                        </div>

                        <!-- Nom du Père en Arabe -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomPereAr">Nom du Père (Arabe)</label>
                            <input type="text" name="nomPereAr" id="nomPereAr" class="form-control">
                        </div>

                        <!-- Nom de la Mère en Français -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomMereFr">Nom de la Mère (Français)</label>
                            <input type="text" name="nomMereFr" id="nomMereFr" class="form-control">
                        </div>

                        <!-- Nom de la Mère en Arabe -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="nomMereAr">Nom de la Mère (Arabe)</label>
                            <input type="text" name="nomMereAr" id="nomMereAr" class="form-control">
                        </div>

                        <!-- Lieu de Naissance -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="lieu_naissance">Lieu de Naissance</label>
                            <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control">
                        </div>

                        <!-- Date de Naissance -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="date_naissance">Date de Naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control">
                        </div>

                        <!-- CINE -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="CINE">CINE</label>
                            <input type="text" name="CINE" id="CINE" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- Mot de passe -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <!-- Voir Plus -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <button type="button" id="voirPlusBtn" class="btn btn-secondary" style="width: 100%;">Voir plus</button>
                        </div>

                        <!-- Champs supplémentaires -->
                        <div id="additionalFields" style="display: none;">
                            <!-- Photo -->
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control-file">
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="category_fonctionnaire_id">Category Fonctionnaire</label>
                                <select name="category_fonctionnaire_id" id="category_fonctionnaire_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nomFr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="id_matricule">Matricule</label>
                                <select name="id_matricule" id="id_matricule" class="form-control" required>
                                    <option value="">Sélectionner un matricule</option>
                                    @foreach ($matricules as $matricule)
                                        <option value="{{ $matricule->id }}">{{ $matricule->numero }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="id_grade">Grade</label>
                                <select name="id_grade" id="id_grade" class="form-control" required>
                                    <option value="">Sélectionner un grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->nomFr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="id_division">Division</label>
                                <select name="id_division" id="id_division" class="form-control" required>
                                    <option value="">Sélectionner une division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->nomAr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="id_service">Service</label>
                                <select name="id_service" id="id_service" class="form-control" required>
                                    <option value="">Sélectionner un service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->nomFr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="id_status">Statut</label>
                                <select name="id_status" id="id_status" class="form-control" required>
                                    <option value="">Sélectionner un statut</option>
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat->id }}">{{ $stat->status_fonctionnaire }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="filiere">Filière</label>
                                <input type="text" name="filiere" id="filiere" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="CNOPS">CNOPS</label>
                                <input type="text" name="CNOPS" id="CNOPS" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="date_service">Date de Service</label>
                                <input type="date" name="date_service" id="date_service" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="numeroPPR">Numéro PPR</label>
                                <input type="text" name="numeroPPR" id="numeroPPR" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="date_grade">Date de Grade</label>
                                <input type="date" name="date_grade" id="date_grade" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="date_echellon">Date d'Echelon</label>
                                <input type="date" name="date_echellon" id="date_echellon" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="mission_respo">Mission Responsable</label>
                                <input type="text" name="mission_respo" id="mission_respo" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="local">Local</label>
                                <input type="text" name="local" id="local" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="mutuelle">Mutuelle</label>
                                <input type="text" name="mutuelle" id="mutuelle" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="solde_conger">Solde Conger</label>
                                <input type="number" name="solde_conger" id="solde_conger" class="form-control">
                            </div>

                            <!-- Section Enfants -->
                            <div id="enfantsSection" style="margin-top: 20px;">
                                <h5>Informations sur les Enfants</h5>
                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][nom_enfant]">Nom de l'Enfant</label>
                                    <input type="text" name="enfants[0][nom_enfant]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][prenom_enfant]">Prénom de l'Enfant</label>
                                    <input type="text" name="enfants[0][prenom_enfant]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][date_naissance]">Date de Naissance</label>
                                    <input type="date" name="enfants[0][date_naissance]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][age16]">Moins de 16 ans</label>
                                    <select name="enfants[0][age16]" class="form-control">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][scolaire]">Scolarisé</label>
                                    <select name="enfants[0][scolaire]" class="form-control">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="enfants[0][handicap]">Handicapé</label>
                                    <select name="enfants[0][handicap]" class="form-control">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>



                                <button type="button" class="btn btn-secondary" onclick="addEnfant()">Ajouter Enfant</button>
                            </div>

                            <!-- Section Conjoints -->
                            <div id="conjointsSection" style="margin-top: 20px;">
                                <h5>Informations sur les Conjoints</h5>
                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="maries[0][nom]">Nom du Conjoint</label>
                                    <input type="text" name="maries[0][nom]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="maries[0][prenom]">Prénom du Conjoint</label>
                                    <input type="text" name="maries[0][prenom]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="maries[0][date_naissance]">Date de Naissance</label>
                                    <input type="date" name="maries[0][date_naissance]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="maries[0][date_mariage]">Date de Mariage</label>
                                    <input type="date" name="maries[0][date_mariage]" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 15px;">
                                    <label for="maries[0][profession]">Profession</label>
                                    <input type="text" name="maries[0][profession]" class="form-control">
                                </div>

                                <button type="button" class="btn btn-secondary" onclick="addConjoint()">Ajouter Conjoint</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Créer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('voirPlusBtn').addEventListener('click', function() {
        var additionalFields = document.getElementById('additionalFields');
        if (additionalFields.style.display === 'none') {
            additionalFields.style.display = 'block';
            this.textContent = 'Voir moins';
        } else {
            additionalFields.style.display = 'none';
            this.textContent = 'Voir plus';
        }
    });

    function addEnfant() {
        var enfantSection = document.getElementById('enfantsSection');
        var enfantTemplate = `
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][nom_enfant]">Nom de l'Enfant</label>
                <input type="text" name="enfants[0][nom_enfant]" class="form-control">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][prenom_enfant]">Prénom de l'Enfant</label>
                <input type="text" name="enfants[0][prenom_enfant]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][date_naissance]">Date de Naissance</label>
                <input type="date" name="enfants[0][date_naissance]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][age16]">Moins de 16 ans</label>
                <select name="enfants[0][age16]" class="form-control">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][scolaire]">Scolarisé</label>
                <select name="enfants[0][scolaire]" class="form-control">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="enfants[0][handicap]">">Handicapé</label>
                <select name="enfants[0][handicap]">" class="form-control">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>



        `;
        enfantSection.insertAdjacentHTML('beforeend', enfantTemplate);
    }

    function addConjoint() {
        var conjointSection = document.getElementById('conjointsSection');
        var conjointTemplate = `
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="maries[0][nom]">Nom du Conjoint</label>
                <input type="text" name="maries[0][nom]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="maries[0][prenom]">Prénom du Conjoint</label>
                <input type="text" name="maries[0][prenom]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="maries[0][date_naissance]">Date de Naissance</label>
                <input type="date" name="maries[0][date_naissance]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="maries[0][date_mariage]">Date de Mariage</label>
                <input type="date" name="maries[0][date_mariage]" class="form-control">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="maries[0][profession]">Profession</label>
                <input type="text" name="maries[0][profession]" class="form-control">
            </div>
        `;
        conjointSection.insertAdjacentHTML('beforeend', conjointTemplate);
    }
</script>
@endsection