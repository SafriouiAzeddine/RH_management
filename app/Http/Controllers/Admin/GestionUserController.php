<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Grade;
use App\Models\Matricule;
use App\Models\Service;
use App\Models\StatusFonctionnaire;
use App\Models\User;
use App\Models\Enfant;
use App\Models\Marie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Age;
use Carbon\Carbon;
use App\Models\CategoryFonctionnaire;
use App\Models\Demande;
use App\Models\StatusDemande;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class GestionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', '!=', '1')->with(['matricule', 'grade', 'division', 'service','age'])->get();
            $dataage=Age::all();
            if($request->filled('from_date') && $request->filled('to_date'))
            {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
            if ($request->filled('min_age') && $request->filled('max_age')) {
                $ageIds = Age::whereBetween('age', [$request->min_age, $request->max_age])->pluck('id');
                $data = $data->whereIn('age_id',$ageIds);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d');
                })
                ->editColumn('photo', function ($user) {
                    return $user->photo ? '<img src="' . asset('upload_files/photos/' . $user->photo) . '" alt="Photo" style="width: 50px; height: 50px; object-fit: cover;">' : 'N/A';
                })
                ->editColumn('nomFr', function ($user) {
                    return $user->nomFr;
                })
                ->editColumn('prenomFr', function ($user) {
                    return $user->prenomFr;
                })
                ->editColumn('age', function ($user) {
                    return $user->age_id ? $user->age->age : 'N/A';
                })
                ->editColumn('is_congé', function ($user) {
                    return $user->is_congé ? 'Oui' : 'Non';
                })
                ->editColumn('matricule', function ($user) {
                    return $user->id_matricule ? $user->matricule->numero : 'N/A';
                })
                ->editColumn('grade', function ($user) {
                    return $user->id_grade ? $user->grade->nomFr : 'N/A';
                })
                ->editColumn('division', function ($user) {
                    return $user->id_division ? $user->division->nomAr : 'N/A';
                })
                ->editColumn('service', function ($user) {
                    return $user->id_service ? $user->service->nomFr : 'N/A';
                })
                ->addColumn('action', function ($user) {
                    return '
                        <a href="' . route('users.show', $user->id) . '" class="btn btn-info btn-sm">Voir</a>
                        <a href="' . route('users.edit', $user->id) . '" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="' . route('users.destroy', $user->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\')">Supprimer</button>
                        </form>
                        <a href="' . route('recapadd.edit', $user->id) . '" class="btn btn-warning btn-sm">Ajoute Recape</a>
                    ';
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        return view('RH.users.listusers'); // Update to the actual view name
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    private function handlePhotoUpload(Request $request)
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/photos', $photoName);
            return $photoName;
        }
        return null;
    }
    */

    public function create()
    {
        
        $divisions = Division::all();
        $services = Service::all();
        $grades = Grade::all();
        $matricules = Matricule::all();
        $status = StatusFonctionnaire::all();
        $marie = Marie::all();
        $categories = CategoryFonctionnaire::all();
        /*

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
        */
        return view('RH.users.create', compact('divisions', 'services', 'grades', 'matricules', 'status','marie','categories'
    ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données d'entrée
    $validatedData = $request->validate([
        'nomFr' => 'required|string|max:255',
        'nomAr' => 'required|string|max:255',
        'prenomFr' => 'required|string|max:255',
        'prenomAr' => 'required|string|max:255',
        'nomPereFr' => 'nullable|string|max:255',
        'nomPereAr' => 'nullable|string|max:255',
        'nomMereFr' => 'nullable|string|max:255',
        'nomMereAr' => 'nullable|string|max:255',
        'lieu_naissance' => 'required|string|max:255',
        'date_naissance' => 'required|date',
        'CINE' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'category_fonctionnaire_id' => 'required|exists:category_fonctionnaires,id',
        'id_matricule' => 'required|exists:matricules,id',
        'id_grade' => 'required|exists:grades,id',
        'id_division' => 'required|exists:divisions,id',
        'id_service' => 'required|exists:services,id',
        'id_status' => 'required|exists:status_fonctionnaires,id',
        'filiere' => 'required|string|max:255',
        'CNOPS' => 'required|string|max:255',
        'date_service' => 'required|date',
        'numeroPPR' => 'required|string|max:255',
        'date_grade' => 'required|date',
        'date_echellon' => 'required|date',
        'mission_respo' => 'required|string|max:255',
        'local' => 'required|string|max:255',
        'mutuelle' => 'required|string|max:255',
        'solde_conger' => 'required|integer',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'enfants' => 'array',
        'enfants.*.nom_enfant' => 'nullable|string',
        'enfants.*.date_naissance' => 'nullable|date',
        'enfants.*.age16' => 'nullable|boolean',
        'enfants.*.scolaire' => 'nullable|boolean',
        'enfants.*.handicap' => 'nullable|boolean',
        'enfants.*.prenom_enfant' => 'nullable|string',
        'maries.*.nom' => 'nullable|string',
        'maries.*.prenom' => 'nullable|string',
        'maries.*.date_naissance' => 'nullable|date',
        'maries.*.date_mariage' => 'nullable|date',
        'maries.*.profession' => 'nullable|string',
    ]);

    // Création d'un nouvel utilisateur
    $user = new User();
    // Handle photo upload
    if ($request->hasFile('photo')) {
        // Generate a new photo name
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        
        // Move the photo to the desired directory
        $photo->move(public_path('upload_files/photos'), $photoName);
        
        // If updating an existing user, delete the old photo if it exists
        if ($user->photo && file_exists(public_path('upload_files/photos/' . $user->photo))) {
            unlink(public_path('upload_files/photos/' . $user->photo));
        }

        // Update the user's photo field
        $user->photo = $photoName;
    }
    


        $user->nomFr = $request->input('nomFr');
        $user->nomAr = $request->input('nomAr');
        $user->prenomFr = $request->input('prenomFr');
        $user->prenomAr = $request->input('prenomAr');
        $user->nomPereFr = $request->input('nomPereFr');
        $user->nomPereAr = $request->input('nomPereAr');
        $user->nomMereFr = $request->input('nomMereFr');
        $user->nomMereAr = $request->input('nomMereAr');
        $user->lieu_naissance = $request->input('lieu_naissance');
        $user->date_naissance = $request->input('date_naissance');
        $user->CINE = $request->input('CINE');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->category_fonctionnaire_id = $request->input('category_fonctionnaire_id');
        $user->id_matricule = $request->input('id_matricule');
        $user->id_grade = $request->input('id_grade');
        $user->id_division = $request->input('id_division');
        $user->id_service = $request->input('id_service');
        $user->id_status = $request->input('id_status');
        $user->filiere = $request->input('filiere');
        $user->CNOPS = $request->input('CNOPS');
        $user->date_service = $request->input('date_service');
        $user->numeroPPR = $request->input('numeroPPR');
        $user->date_grade = $request->input('date_grade');
        $user->date_echellon = $request->input('date_echellon');
        $user->mission_respo = $request->input('mission_respo');
        $user->local = $request->input('local');
        $user->mutuelle = $request->input('mutuelle');
        $user->solde_conger = $request->input('solde_conger');
        $soldeconger=$user->solde_conger;
        $user->solde_conger_initial=$soldeconger;
        $user->photo = $photoName;

         // Calcul de l'âge
        if ($request->filled('date_naissance')) {
            $birthDate = Carbon::parse($request->input('date_naissance'));
            $ageValue = Carbon::now()->diffInYears($birthDate);

            // Trouver ou créer l'âge correspondant
            $age = Age::firstOrCreate(['age' => $ageValue]);

            // Associer l'âge à l'utilisateur
            $user->age()->associate($age);
        }

        // Sauvegarder l'utilisateur
        $user->save();

        // Ajout des enfants
        if ($request->has('enfants')) {
            foreach ($request->input('enfants') as $enfantData) {
                $enfant = new Enfant($enfantData);
                $user->enfants()->save($enfant);
            }
        }

        // Ajout des conjoints
        if ($request->has('maries')) {
            foreach ($request->input('maries') as $marieData) {
                $marie = new Marie($marieData);
                $user->maries()->save($marie);
            }
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');

    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('RH.users.showuser',compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $divisions = Division::all(); // Assuming you have a Division model
        $services = Service::all();
        $grades = Grade::all();
        $matricules = Matricule::all();
        $status = StatusFonctionnaire::all();
        $marie = Marie::all();
        $categories = CategoryFonctionnaire::all();
        $user = User::find($id);
        $photoName=$user->photo;
        return view('RH.users.edituser',compact('user','divisions','services','grades','matricules','status','marie','categories','photoName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données d'entrée
        $validatedData =  $request->validate([
       'nomFr' => 'required|string|max:255',
        'nomAr' => 'required|string|max:255',
        'prenomFr' => 'required|string|max:255',
        'prenomAr' => 'required|string|max:255',
        'nomPereFr' => 'nullable|string|max:255',
        'nomPereAr' => 'nullable|string|max:255',
        'nomMereFr' => 'nullable|string|max:255',
        'nomMereAr' => 'nullable|string|max:255',
        'lieu_naissance' => 'required|string|max:255',
        'date_naissance' => 'required|date',
        'CINE' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'required|string|min:8',
        'category_fonctionnaire_id' => 'required|exists:category_fonctionnaires,id',
        'id_matricule' => 'required|exists:matricules,id',
        'id_grade' => 'required|exists:grades,id',
        'id_division' => 'required|exists:divisions,id',
        'id_service' => 'required|exists:services,id',
        'id_status' => 'required|exists:status_fonctionnaires,id',
        'filiere' => 'required|string|max:255',
        'CNOPS' => 'required|string|max:255',
        'date_service' => 'required|date',
        'numeroPPR' => 'required|string|max:255',
        'date_grade' => 'required|date',
        'date_echellon' => 'required|date',
        'mission_respo' => 'required|string|max:255',
        'local' => 'required|string|max:255',
        'mutuelle' => 'required|string|max:255',
        'solde_conger' => 'required|integer',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'enfants' => 'array',
        'enfants.*.nom_enfant' => 'nullable|string',
        'enfants.*.date_naissance' => 'nullable|date',
        'enfants.*.age16' => 'nullable|boolean',
        'enfants.*.scolaire' => 'nullable|boolean',
        'enfants.*.handicap' => 'nullable|boolean',
        'enfants.*.prenom_enfant' => 'nullable|string',
        'maries.*.nom' => 'nullable|string',
        'maries.*.prenom' => 'nullable|string',
        'maries.*.date_naissance' => 'nullable|date',
        'maries.*.date_mariage' => 'nullable|date',
        'maries.*.profession' => 'nullable|string',
        ]);

        // Récupération de l'utilisateur à mettre à jour
        $user = User::findOrFail($id);

        // Gestion de l'upload de la photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            
            // Delete the old photo if it exists
            if ($user->photo) {
                $oldPhotoPath = public_path('upload_files/photos/' . $user->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            
            // Store the new photo
            $photo->move(public_path('upload_files/photos'), $photoName);
            
            // Update the photo field in the user record
            $user->photo = $photoName;
        }

        // Mise à jour des autres informations de l'utilisateur
        $user->nomFr = $request->input('nomFr');
        $user->nomAr = $request->input('nomAr');
        $user->prenomFr = $request->input('prenomFr');
        $user->prenomAr = $request->input('prenomAr');
        $user->nomPereFr = $request->input('nomPereFr');
        $user->nomPereAr = $request->input('nomPereAr');
        $user->nomMereFr = $request->input('nomMereFr');
        $user->nomMereAr = $request->input('nomMereAr');
        $user->lieu_naissance = $request->input('lieu_naissance');
        $user->date_naissance = $request->input('date_naissance');
        $user->CINE = $request->input('CINE');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->id_matricule = $request->input('id_matricule');
        $user->id_grade = $request->input('id_grade');
        $user->id_division = $request->input('id_division');
        $user->id_service = $request->input('id_service');
        $user->id_status = $request->input('id_status');
        $user->filiere = $request->input('filiere');
        $user->CNOPS = $request->input('CNOPS');
        $user->date_service = $request->input('date_service');
        $user->numeroPPR = $request->input('numeroPPR');
        $user->date_grade = $request->input('date_grade');
        $user->date_echellon = $request->input('date_echellon');
        $user->mission_respo = $request->input('mission_respo');
        $user->local = $request->input('local');
        $user->mutuelle = $request->input('mutuelle');
        $user->solde_conger = $request->input('solde_conger');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->category_fonctionnaire_id = $request->input('category_fonctionnaire_id');
        $user->id_matricule = $request->input('id_matricule');
        $user->id_grade = $request->input('id_grade');
        $user->id_division = $request->input('id_division');
        $user->id_service = $request->input('id_service');
        $user->id_status = $request->input('id_status');
        $user->id_marie = $request->input('id_marie');
         // Calcul de l'âge
         $birthDate = Carbon::parse($request->input('date_naissance'));
         $ageValue = Carbon::now()->diffInYears($birthDate);
 
         // Trouver ou créer l'âge correspondant
         $age = Age::firstOrCreate(['age' => $ageValue]);
        $user->save();
    
        // Mise à jour des enfants
        if ($request->has('enfants')) {
            $user->enfants()->delete(); // Supprimer les enfants existants
            foreach ($request->input('enfants') as $enfantData) {
                $enfant = new Enfant($enfantData);
                $user->enfants()->save($enfant);
            }
        }
    
        // Mise à jour des conjoints
        if ($request->has('maries')) {
            $user->maries()->delete(); // Supprimer les conjoints existants
            foreach ($request->input('maries') as $marieData) {
                $marie = new Marie($marieData);
                $user->maries()->save($marie);
            }
        }
    

        return redirect()->route('users.index')->with('success', 'Informations utilisateur mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     */
    //filtrage user par age
    public function filterByAge(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'age_min' => 'required|integer|min:0',
            'age_max' => 'required|integer|min:0'
        ]);
        $age_min = $request->input('age_min');
        $age_max = $request->input('age_max');

        $Users = User::join('ages', 'users.age_id', '=', 'ages.id')
                         ->whereBetween('ages.age', [$age_min, $age_max])
                         ->select('users.id') // Sélectionner uniquement les IDs des utilisateurs
                         ->get();

        // Extraire les IDs des utilisateurs filtrés
        $userIds = $Users->pluck('id')->toArray();

        // Utiliser whereIn avec les IDs extraits
        $users = User::whereIn('id', $userIds)->get();

        // Récupérer les demandes associées à ces utilisateurs
        $demandes = Demande::whereIn('id_user', $users->pluck('id'))->get();

        // Calcul des statistiques de demandes
        $totalUsers = $users->count();
        $totalDemandes = $demandes->count();
        $statusTraite = StatusDemande::where('status_demande', 'Traité')->first();
        if ($statusTraite) {
            $statusTraiteId = $statusTraite->id;
        } else {
            // Définir une valeur par défaut ou gérer l'absence de statut
            $statusTraiteId = null; // ou une autre valeur par défaut appropriée
        }
        $statusNonTraite = StatusDemande::where('status_demande', 'Non Traité')->first();

        // Vérifier si le résultat est null
        if ($statusNonTraite) {
            $statusNonTraiteId = $statusNonTraite->id;
        } else {
            // Définir une valeur par défaut ou gérer l'absence de statut
            $statusNonTraiteId = null; // ou une autre valeur par défaut appropriée
        }
        $demandesTraitees = $demandes->where('id_status', $statusTraiteId)->count();

        // Compter les demandes non traitées
        $demandesNonTraitees = $demandes->where('id_status', $statusNonTraiteId)->count();

        // Passer les données à la vue
        return view('RH.dashboard.dashboard', compact('users', 'demandes', 'totalUsers', 'totalDemandes', 'demandesTraitees', 'demandesNonTraitees'));
    }

    
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->enfants()->delete();
        $user->maries()->delete();
        $user->demandes()->delete();

        // Supprimer la photo de l'utilisateur s'il y en a une
        if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
            Storage::delete('public/photos/' . $user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

}