<?php
// app/Http/Controllers/AbsenceController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GantDivision;

class AbsenceController extends Controller
{
    public function showAbsences()
    {
        // Fetch leave requests with related employee data
        $absences = GantDivision::with('user')->get();
        return view('absences.gantt', compact('absences'));
    }
}
