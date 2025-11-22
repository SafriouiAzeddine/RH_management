<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendControllerAdmin extends Controller
{
    public function index(){
        $showCharts=true;

        $totalUsers = User::where('role','!=', '1')->count();
        $totalDemandes = Demande::count();
        $demandesNonTraitees = Demande::where('id_status', '1')->count();
        $demandesTraitees = Demande::where('id_status','!=', '1')->count();
        $Atesstationtravail = Demande::where('id_typeDemande', '1')->count();
        $congéexeptionnel = Demande::where('id_typeDemande', '2')->count();
        $congé = Demande::where('id_typeDemande', '3')->count();
        $permissionabs = Demande::where('id_typeDemande', '4')->count();
        
         // Calcul des pourcentages
         $pourcentageNonTraitees = $totalDemandes > 0 ? ($demandesNonTraitees / $totalDemandes) * 100 : 0;
         $pourcentageTraitees = $totalDemandes > 0 ? ($demandesTraitees / $totalDemandes) * 100 : 0;
         

         $pourcentageAttestation = $totalDemandes > 0 ? ($Atesstationtravail / $totalDemandes) * 100 : 0;
         $pourcentageDocument = $totalDemandes > 0 ? ($congéexeptionnel / $totalDemandes) * 100 : 0;
         $pourcentageCongé = $totalDemandes > 0 ? ($congé / $totalDemandes) * 100 : 0;
         $pourcentageCongé = $totalDemandes > 0 ? ($permissionabs / $totalDemandes) * 100 : 0;
 

        return view('RH.dashboard.dashboard', compact('showCharts','totalUsers', 'totalDemandes', 'demandesNonTraitees', 'demandesTraitees','pourcentageNonTraitees',
                    'pourcentageTraitees','Atesstationtravail','congéexeptionnel','congé',
                    'pourcentageAttestation','pourcentageDocument','pourcentageCongé','permissionabs'));
    }
}
