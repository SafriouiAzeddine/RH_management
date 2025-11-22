<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class GanttDemande extends Controller
{
    public function generateGanttChart(Request $request)
    {
        $users = User::where('role','!=',1)->with(['demandes' => function ($query) {
            $query->where('id_status', 2)
                ->whereIn('id_typeDemande', [2, 3, 4]);
        }])->get();

        // Charger le modèle Excel
        $spreadsheet = IOFactory::load(storage_path('app/public/gantt_chart.xlsx'));

        // Pour chaque mois
        foreach (range(1, 12) as $month) {
            $monthName = Carbon::create()->month($month)->format('F');
            $sheet = $spreadsheet->getSheetByName($monthName);
            
            // Si la feuille n'existe pas, passer au mois suivant
            if (!$sheet) {
                continue;
            }

            $currentYear = Carbon::now()->year;
            $sheet->setCellValue('AH4', $currentYear);

            foreach (range(1, 31) as $day) {
                $date = Carbon::create($currentYear, $month, $day);
                $dayName = $date->format('l');
                $dayColumnIndex = $day + 2;
                $dayColumn = $sheet->getCellByColumnAndRow($dayColumnIndex, 6)->getColumn();
                $sheet->setCellValue($dayColumn . '5', $dayName);
            }

            $row = 7;
            $totalDaysPerMonth = 0;
            $dailyTotals = array_fill(1, 31, 0);

            foreach ($users as $user) {
                $sheet->setCellValue('B' . $row, $user->email);
                $userTotalDays = 0;

                foreach ($user->demandes as $leave) {
                    $startDate = Carbon::parse($leave->date_debut);
                    $endDate = Carbon::parse($leave->date_fin);

                    if ($startDate->month == $month || $endDate->month == $month) {
                        $type = '';
                        switch ($leave->id_typeDemande) {
                            case 2:
                                $type = 'CE';
                                $color = 'F4CDAC';
                                break;
                            case 3:
                                $type = 'CA';
                                $color = 'DE7465';
                                break;
                            case 4:
                                $type = 'PA';
                                $color = 'ADD8E6';
                                break;
   
                        }

                        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                            if ($date->month == $month) {
                                $dayColumnIndex = $date->day + 2;
                                $dayColumn = $sheet->getCellByColumnAndRow($dayColumnIndex, 6)->getColumn();
                                $cell = $dayColumn . $row;
                                $sheet->setCellValue($cell, $type);
                                // Appliquer la couleur de fond
                                $sheet->getStyle($cell)->applyFromArray([
                                    'fill' => [
                                        'fillType' => Fill::FILL_SOLID,
                                        'startColor' => ['rgb' => $color]
                                    ]
                                ]);

                                if ($type === 'CA' || $type === 'CE') {
                                    $userTotalDays++;
                                    $dailyTotals[$date->day]++;
                                }
                            }
                        }
                    }
                }

                $sheet->setCellValue('AH' . $row, $userTotalDays);
                $totalDaysPerMonth += $userTotalDays;

                // Style for data rows
                $sheet->getStyle('B' . $row . ':AH' . $row)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 10,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],

                ]);

                $row++;
            }

            $totalRow = $row;
            $sheet->setCellValue('B' . $totalRow, 'Total');
            $sheet->setCellValue('AH' . $totalRow, $totalDaysPerMonth);

            foreach ($dailyTotals as $day => $total) {
                $dayColumnIndex = $day + 2;
                $dayColumn = $sheet->getCellByColumnAndRow($dayColumnIndex, 6)->getColumn();
                $sheet->setCellValue($dayColumn . $totalRow, $total);
            }

            $row++;

            // Apply styles to row 6
            $sheet->getStyle('B6:AH6')->applyFromArray([
                'font' => [
                    'name' => 'Arial',
                    'size' => 12,
                    'bold' => true,
                    'color' => ['rgb' => '000000'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D3D3D3'], // Light grey background
                ],
            ]);

            // Apply styles to row 5
            $sheet->getStyle('B5:AH5')->applyFromArray([
                'font' => [
                    'name' => 'Arial',
                    'size' => 12,
                    'bold' => true,
                    'color' => ['rgb' => '000000'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9EAD3'], // Light green background
                ],
            ]);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = 'gantt_chart_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
