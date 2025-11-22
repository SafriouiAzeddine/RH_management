<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\TypeDemande;
use App\Notifications\DemandeStatusConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;
//for excel
use App\Exports\GanttChartExport;
use Maatwebsite\Excel\Facades\Excel;

class GestionDemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Demande::where('id_status','!=','1')->with(['typeDemande', 'statusDemande', 'user'])->get();
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
            ->editColumn('solde_conger', function ($demande) {
                return $demande->user->solde_conger;
            })
            ->editColumn('user_name', function ($demande) {
                return $demande->user->nomFr . ' ' . $demande->user->prenomFr ;
            })
            ->editColumn('date_fin', function ($demande) {
                return in_array($demande->id_typeDemande, [2, 3, 4]) ? $demande->date_fin->format('Y-m-d') : 'N/A';
            })
            ->editColumn('photo', function ($demande) {
                return $demande->user->photo ? '<img src="' . asset('upload_files/photos/' . $demande->user->photo) . '" alt="Photo" style="width: 50px; height: 50px; object-fit: cover;">' : 'N/A';
            })
            ->addColumn('action', function ($demande) {
                if ($demande->id_status == 2) {
                    return '
                        <a href="' . route('demande/exportword', $demande->id) . '" class="btn btn-info btn-sm">Imprimer Word</a>
                    ';
                } else {
                    return '
                        <button class="btn btn-info btn-sm" disabled>Imprimer Word</button>
                    ';
                }
            })
            ->rawColumns(['photo','status_demande', 'action'])
            ->make(true);
        }


        return view('RH.demandes.listdemandes');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
         $demande = Demande::find($id);
         $status = $request->input('status');
 
         // Récupérer l'utilisateur
         $user = User::find($demande->id_user);
 
         if ($status == 'accepté') {
             if ($demande->nbr_jours <= $user->solde_conger) {
                 // Déduire les jours de congé du solde de congé de l'utilisateur
                 $user->solde_conger -= $demande->nbr_jours;
 
                 // Vérifier si la date actuelle est comprise entre la date de début et la date de fin du congé
                 $now = Carbon::now();
                 if ($now->between(Carbon::parse($demande->date_debut), Carbon::parse($demande->date_fin))) {
                     $user->is_congé = true; // Statut en congé
                 }
 
                 // Sauvegarder les modifications de l'utilisateur
                 $user->save();
 
                 // Mettre à jour le statut de la demande
                 $demande->id_status = 2; // Statut accepté
                 $statusMessage = 'accepté';
 
                 // Ajouter un message de confirmation
                 $message = 'La demande a été acceptée et le solde de congé mis à jour avec succès.';
                 $alertType = 'success';

                // Update the Gantt chart Excel file
                // Generate and store the Excel file
                //$export = new GanttChartExport($demande);
                //Excel::store($export, 'public/gantt_chart.xlsx');
             } else {
                 // Ajouter un message d'erreur si le solde de congé est insuffisant
                 return redirect()->route('listdemandes.index')->with([
                     'message' => 'Le nombre de jours demandés dépasse le solde de congé disponible.',
                     'alertType' => 'error'
                 ]);
             }
         } elseif ($status == 'refusé') {
             $demande->id_status = 3; // Statut refusé
             $statusMessage = 'refusé';
             $message = 'La demande a été refusée avec succès.';
             $alertType = 'warning';
         }
 
         // Sauvegarder les modifications de la demande
         $demande->save();
 
         // Envoyer une notification à l'utilisateur
         $user->notify(new DemandeStatusConfirmation($demande, $statusMessage));
 
         return redirect()->route('listdemandes.index')->with([
             'message' => $message,
             'alertType' => $alertType
         ]);
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

    public function exportword($id){
        
        $demande=Demande::find($id);


        $typeDemande=$demande->typeDemande->type_demande;
        $statusDemande=$demande->statusDemande->status_demande;
        //$userEmail=$demande->user->email;
        $typeDemandeId=$demande->typeDemande->id;
        $user=$demande->user;
        $dateDebut = $demande->date_debut;
        $nbrJours = $demande->nbr_jours;
        $dateFin = $demande->date_fin;
        // Récupérer l'avant-dernier congé (le plus récent avant la demande actuelle)
        $previousDemande = Demande::where('id_user', $user->id)
        ->where('id_typeDemande', $typeDemandeId)
        ->where('id', '!=', $demande->id)
        ->where('id_status', 2) // Statut accepté
        ->orderBy('date_debut', 'desc')
        ->first();
    
        if ($typeDemandeId == 3) {

            $templateProcessor=new TemplateProcessor('word-template-admin/arreté_de_congé_annuel.docx');
            //$templateProcessor->setValue('typeDemande', $typeDemande);
            //$templateProcessor->setValue('statusDemande', $statusDemande);
    
            $templateProcessor->setValue('division', $user->division->nomAr);
            $templateProcessor->setValue('username', $user->nomAr . ' ' . $user->prenomAr);
            //$templateProcessor->setValue('prenom', $user->prenomFr);
            $templateProcessor->setValue('fonction', $user->categoryFonctionnaire->nomAr);
            $templateProcessor->setValue('grade', $user->grade->nomAr);
            // Date in Arabic format
            Carbon::setLocale('ar');
            $dateDebutAr = \Carbon\Carbon::parse($dateDebut)->translatedFormat('l j F Y');
            $dateNow = Carbon::now();
            $dateNowAr = \Carbon\Carbon::parse($dateNow)->translatedFormat('l j F Y');
         
            $templateProcessor->setValue('date_debut', $dateDebutAr);
            $templateProcessor->setValue('now', $dateNowAr);

            $templateProcessor->setValue('nbr_jours', $nbrJours);
            $currentYear = Carbon::now()->year;
            $templateProcessor->setValue('current_year', $currentYear);

            // Vérifier si l'avant-dernier congé existe
            if ($previousDemande) {
                $previousDateDebutAr = \Carbon\Carbon::parse($previousDemande->date_debut)->translatedFormat('l j F Y');
                $templateProcessor->setValue('previous_date_debut', $previousDateDebutAr);
                $templateProcessor->setValue('previous_jours', ' سبق له أن استفاد من رخصة سنوية مدتها ' . $previousDemande->nbr_jours);
            } else {
                // Si l'avant-dernier congé n'existe pas, affichez un message spécifique
                $templateProcessor->setValue('previous_date_debut', 'Pas de congé précédent trouvé');
                $templateProcessor->setValue('previous_jours', 'لم يسبق له أن استفاد من أي رخصة سنوية' );
            }



            
            $fileName=$typeDemande . '_' . $user->nomAr;
            
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);

 
        }elseif ($typeDemandeId == 2 || $typeDemandeId == 4) {

            // Utilisation du modèle Word pour les demandes de type 2 et 4
            $templateProcessor = new TemplateProcessor('word-template-admin/arreté_de_permission.docx');
        
            // Remplir les valeurs du modèle
            $templateProcessor->setValue('division', $user->division->nomAr);
            $templateProcessor->setValue('username', $user->nomAr . ' ' . $user->prenomAr);
            $templateProcessor->setValue('fonction', $user->categoryFonctionnaire->nomAr);
            $templateProcessor->setValue('grade', $user->grade->nomAr);
            $templateProcessor->setValue('nbr_jours', $nbrJours);
        
            // Date en format arabe
            Carbon::setLocale('ar');
            $dateDebutAr = \Carbon\Carbon::parse($dateDebut)->translatedFormat('l j F Y');
            $dateNow = Carbon::now();
            $dateNowAr = \Carbon\Carbon::parse($dateNow)->translatedFormat('l j F Y');
        
            $templateProcessor->setValue('date_debut', $dateDebutAr);
            $templateProcessor->setValue('now', $dateNowAr);
        
            $currentYear = Carbon::now()->year;
            $templateProcessor->setValue('current_year', $currentYear);
        
            // Vérifier la demande précédente
            $previousDemande = Demande::where('id_user', $user->id)
                ->whereIn('id_typeDemande', [2, 4])
                ->where('created_at', '<', $demande->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
        
            if ($previousDemande) {
                $previousDateDebutAr = \Carbon\Carbon::parse($previousDemande->date_debut)->translatedFormat('l j F Y');
                $previousJours = 'سبق له أن استفاد من رخصة ' . 
                ($previousDemande->id_typeDemande == 2 ? 'استثنائية' : 'تغيب') .
                ' مدتها ' . ' ' . 
                ($previousDemande->nbr_jours == 1 ? 'يوم واحد' : 
                ($previousDemande->nbr_jours == 2 ? 'يومان' : $previousDemande->nbr_jours . 'أيام')) .
                $templateProcessor->setValue('previous_date_debut', $previousDateDebutAr);
                $templateProcessor->setValue('previous_jours', $previousJours);
            } else {
                $templateProcessor->setValue('previous_date_debut', 'لم يتم العثور على رخصة سابقة');
                $templateProcessor->setValue('previous_jours', 'لم يسبق له أن استفاد من أي رخصة استثنائية أو رخصة تغيب');
            }
        
            $fileName = $typeDemande . '_' . $user->nomAr;
            $templateProcessor->saveAs($fileName . '.docx');
            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
        }else{

            $templateProcessor=new TemplateProcessor('word-template/attestation_de_travail.docx');
            $templateProcessor->setValue('grade', $user->grade->nomAr);
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


    public function export() 
    {
        $filename="demandes_acceptées.xlsx";
        return Excel::download(new GanttChartExport, $filename);
    }



   
}
