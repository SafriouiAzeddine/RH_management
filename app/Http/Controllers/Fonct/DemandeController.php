<?php

namespace App\Http\Controllers\Fonct;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\TypeDemande;
use App\Models\User;
use App\Notifications\DemandeCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpWord\TemplateProcessor;


class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Demande::where('id_user', auth()->id())->with(['typeDemande', 'statusDemande', 'user'])->get();
            //this filter is help when we wanna just search in actuel month
            //helps if wanna see month by month
            if($request->filled('from_date') && $request->filled('to_date'))
            {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }


            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($demande) {
                return $demande->created_at->format('Y-m-d');
            })
            ->editColumn('type_demande', function ($demande) {
                return $demande->typeDemande->type_demande;
            })
            ->editColumn('status_demande', function ($demande) {
                $badgeClass = '';
            
                switch ($demande->id_status) {
                    case 2:
                        $badgeClass = 'bg-success';
                        break;
                    case 3:
                        $badgeClass = 'bg-danger';
                        break;
                    default:
                        $badgeClass = 'bg-secondary';
                        break;
                }
            
                return '
                        <span class="badge ' . $badgeClass . '">' . htmlspecialchars($demande->statusDemande->status_demande, ENT_QUOTES, 'UTF-8') . '</span>
                    ';
            })            
            ->editColumn('date_debut', function ($demande) {
                return in_array($demande->id_typeDemande, [2, 3, 4]) ? $demande->date_debut->format('Y-m-d') : 'N/A';
            })
            ->editColumn('nbr_jours', function ($demande) {
                return in_array($demande->id_typeDemande, [2, 3, 4]) ? $demande->nbr_jours : 'N/A';
            })
            ->editColumn('date_fin', function ($demande) {
                return in_array($demande->id_typeDemande, [2, 3, 4]) ? $demande->date_fin->format('Y-m-d') : 'N/A';
            })
            ->addColumn('action', function ($demande) {
                if ($demande->id_status == 2) {
                    return '
                        <a href="' . route('demande/word_export', $demande->id) . '" class="btn btn-info btn-sm">Imprimer Word</a>
                    ';
                } else {
                    return '
                        <button class="btn btn-info btn-sm" disabled>Imprimer Word</button>
                    ';
                }
            })
            ->rawColumns(['photo','action','status_demande'])//ajouter action si vous voulez
            ->make(true);
        
        }

        return view('Fonctionnaire.demandes.listdemandes');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typedemandes = TypeDemande::all();
        return view('Fonctionnaire.demandes.create',compact('typedemandes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_typeDemande' => 'required|exists:type_demandes,id',
        ]);
    
        $userId = auth()->id();
        $typeDemandeId = $request->input('id_typeDemande');
    
        // Vérifier si 24 heures se sont écoulées depuis la dernière demande
        $lastDemande = Demande::where('id_user', $userId)
                                ->where('id_typeDemande', $typeDemandeId)
                                ->orderBy('created_at', 'desc')
                                ->first();
    
        if ($lastDemande) {
            $lastDemandeCreatedAt = Carbon::parse($lastDemande->created_at);
            $now = Carbon::now();
    
            if ($now->diffInHours($lastDemandeCreatedAt) < 24) {
                return redirect()->back()->withErrors(['error' => 'Vous devez attendre 24 heures avant de faire une nouvelle demande de ce type.']);
            }
        }
    
    // Récupérer les dates de début et de fin de la nouvelle demande
    $dateDebut = Carbon::parse($request->input('date_debut'));
    $nbrJours = $request->input('nbr_jours');
    $dateFin = $dateDebut->copy()->addDays($nbrJours - 1);

    $demande = new Demande();
    $demande->id_typeDemande = $typeDemandeId;
    $demande->id_status = 1;
    $demande->id_user = $userId;

    if (in_array($typeDemandeId, [2, 3, 4])) {
        // Valider les données pour les types de demande 2, 3, et 4
        $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'nbr_jours' => 'required|integer|min:1',
        ]);

        // Vérifier les chevauchements avec les autres demandes de types 2, 3, et 4
        $overlappingDemande = Demande::where('id_user', $userId)
            ->whereIn('id_typeDemande', [2, 3, 4])
            ->where(function ($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_debut', [$dateDebut, $dateFin])
                      ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                      ->orWhere(function ($query) use ($dateDebut, $dateFin) {
                          $query->where('date_debut', '<=', $dateDebut)
                                ->where('date_fin', '>=', $dateFin);
                      });
            })
            ->first(); // Assurez-vous d'utiliser `first()` et non `get()`

        if ($overlappingDemande) {
            $overlappingDateFin = Carbon::parse($overlappingDemande->date_fin);
            return redirect()->back()->withErrors([
                'error' => 'Vous êtes déjà en congé jusqu\'au ' . $overlappingDateFin->format('d-m-Y') . ' ou une autre demande se chevauche avec votre nouvelle demande.'
            ]);
        }

        // Vérifier le solde pour les demandes de type 2, 3, et 4
        $user = auth()->user();
        if ($nbrJours > $user->solde_conger) {
            return redirect()->back()->withErrors(['error' => 'Votre solde est insuffisant. Vous devez entrer un nombre inférieur ou égal à votre solde de congés.']);
        }

        // Affecter les valeurs à la demande

        $demande->date_debut = $dateDebut;
        $demande->nbr_jours = $nbrJours;
        $demande->date_fin = $dateFin;
        }
            $demande->save();
        
        // Envoyer une notification à l'admin
        $admin = User::where('role', '1')->first();
        $admin->notify(new DemandeCreated($demande));
    
        return redirect()->route('demandes.index')->with('status', 'Demande ajoutée avec succès');
    }
    
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function WordExport($id){

        $demande=Demande::find($id);


        $typeDemande=$demande->typeDemande->type_demande;
        $statusDemande=$demande->statusDemande->status_demande;
        //$userEmail=$demande->user->email;
        $typeDemandeId=$demande->typeDemande->id;
        $user=$demande->user;
        $dateDebut = $demande->date_debut;
        $nbrJours = $demande->nbr_jours;
        $dateFin = $demande->date_fin;
    
        if ($typeDemandeId == 3) {

            $templateProcessor=new TemplateProcessor('word-template/demande_congé_annuel.docx');
            //$templateProcessor->setValue('typeDemande', $typeDemande);
            //$templateProcessor->setValue('statusDemande', $statusDemande);
    
            $templateProcessor->setValue('division', $user->division->nomFr);
            $templateProcessor->setValue('username', $user->nomFr . ' ' . $user->prenomFr);
            //$templateProcessor->setValue('prenom', $user->prenomFr);
            $templateProcessor->setValue('fonction', $user->categoryFonctionnaire->nomFr);


            $templateProcessor->setValue('date_debut', Carbon::parse($dateDebut)->translatedFormat('d F Y'));
            $templateProcessor->setValue('nbr_jours', $nbrJours);
            $templateProcessor->setValue('now', Carbon::now()->format('d/m/Y'));
            $fileName=$typeDemande . '_' . $user->nomFr;
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);

 
        }elseif($typeDemandeId == 2){

            $templateProcessor=new TemplateProcessor('word-template/demande_congé_exceptionnel.docx');
            $templateProcessor->setValue('division', $user->division->nomFr);
            $templateProcessor->setValue('username', $user->nomFr . ' ' . $user->prenomFr);
            //$templateProcessor->setValue('prenom', $user->prenomFr);
            $templateProcessor->setValue('fonction', $user->categoryFonctionnaire->nomFr);


            $templateProcessor->setValue('date_debut', Carbon::parse($dateDebut)->translatedFormat('d F Y'));
            $templateProcessor->setValue('nbr_jours', $nbrJours);
            $templateProcessor->setValue('now', Carbon::now()->format('d/m/Y'));
            $fileName=$typeDemande . '_' . $user->nomFr;
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);


        }elseif($typeDemandeId == 4){

            $templateProcessor=new TemplateProcessor('word-template/demande_permission_abs.docx');
            $templateProcessor->setValue('division', $user->division->nomFr);
            $templateProcessor->setValue('username', $user->nomFr . ' ' . $user->prenomFr);
            //$templateProcessor->setValue('prenom', $user->prenomFr);
            $templateProcessor->setValue('fonction', $user->categoryFonctionnaire->nomFr);


            $templateProcessor->setValue('date_debut', Carbon::parse($dateDebut)->translatedFormat('d F Y'));
            $templateProcessor->setValue('nbr_jours', $nbrJours);
            $templateProcessor->setValue('now', Carbon::now()->format('d/m/Y'));
            $fileName=$typeDemande . '_' . $user->nomFr;
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);


        }else{

            $templateProcessor=new TemplateProcessor('word-template/attestation_de_travail.docx');
            $templateProcessor->setValue('grade', $user->grade->nomFr);
            $templateProcessor->setValue('cin', $user->CINE);
            $templateProcessor->setValue('username', $user->nomFr . ' ' . $user->prenomFr);
            $templateProcessor->setValue('prenom', $user->prenomFr);
            $templateProcessor->setValue('date_debut', Carbon::parse($user->date_service)->format('d/m/Y'));
            $templateProcessor->setValue('now', Carbon::now()->format('d/m/Y'));
            $fileName=$typeDemande . '_' . $user->nomFr;
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);


        }

    }
}
