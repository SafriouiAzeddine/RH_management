<?php

namespace Database\Seeders;

use App\Models\StatusFonctionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusFonctionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['active', 'deces', 'conge', 'retraite'];

        foreach ($statuses as $status) {
            StatusFonctionnaire::create(['nom' => $status]);
        }
    }
}
