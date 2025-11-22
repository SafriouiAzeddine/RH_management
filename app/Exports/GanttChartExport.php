<?php

namespace App\Exports;
use App\Models\Demande;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;



class GanttChartExport implements FromCollection,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Demande::where('id_status', 2)->get()->map(function ($demande) {
            return [
                'Nom' => $demande->user->nomFr,
                'Prenom' => $demande->user->prenomFr,
                'Date Début' => $demande->date_debut,
                'Date Fin' => $demande->date_fin,
                'Nombre de Jours' => $demande->nbr_jours
            ];
        });
    }
    public function headings(): array
    {
            return [
                'Nom',
                'Prenom',
                'Date Début',
                'Date Fin',
            'Nombre de Jours',
        ];
    }
}