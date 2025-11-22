<?php

namespace App\Http\Controllers\Fonct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Demande;
use App\Models\User;

class FrontendController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Total demandes made by the authenticated user
        $totalDemandes = Demande::where('id_user', $user->id)->count();

        // Non-traitees demandes for the authenticated user
        $demandesNonTraitees = Demande::where('id_user', $user->id)->where('id_status', '1')->count();

        // Traitees demandes for the authenticated user
        $demandesTraitees = Demande::where('id_user', $user->id)->where('id_status', '!=', '1')->count();

        // Type-specific demandes for the authenticated user
        $Atesstationtravail = Demande::where('id_user', $user->id)->where('id_typeDemande', '1')->count();
        $congéexeptionnel = Demande::where('id_user', $user->id)->where('id_typeDemande', '2')->count();
        $congé = Demande::where('id_user', $user->id)->where('id_typeDemande', '3')->count();
        $permissionabs = Demande::where('id_user', $user->id)->where('id_typeDemande', '4')->count();

        // Calcul des pourcentages
        $pourcentageNonTraitees = $totalDemandes > 0 ? ($demandesNonTraitees / $totalDemandes) * 100 : 0;
        $pourcentageTraitees = $totalDemandes > 0 ? ($demandesTraitees / $totalDemandes) * 100 : 0;
        $pourcentageAttestation = $totalDemandes > 0 ? ($Atesstationtravail / $totalDemandes) * 100 : 0;
        $pourcentageDocument = $totalDemandes > 0 ? ($congéexeptionnel / $totalDemandes) * 100 : 0;
        $pourcentageCongé = $totalDemandes > 0 ? ($congé / $totalDemandes) * 100 : 0;
        $pourcentageCongé = $totalDemandes > 0 ? ($permissionabs / $totalDemandes) * 100 : 0;

        return view('Fonctionnaire.dashboard.dashboard', compact(
            'totalDemandes', 
            'demandesNonTraitees', 
            'demandesTraitees',
            'pourcentageNonTraitees',
            'pourcentageTraitees',
            'Atesstationtravail',
            'congéexeptionnel',
            'congé',
            'pourcentageAttestation',
            'pourcentageDocument',
            'pourcentageCongé',
            'permissionabs'
        ));
    }
}
