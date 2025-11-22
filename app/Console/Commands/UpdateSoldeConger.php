<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateSoldeConger extends Command
{
    protected $signature = 'update:solde_conger';
    protected $description = 'Met à jour le solde de congé des utilisateurs au début de chaque année';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();
        //policy

        foreach ($users as $user) {
            // Met à jour le solde de congé avec le solde initial
            $user->solde_conger = $user->solde_conger_initial;
            $user->save();
        }

        $this->info('Le solde de congé des utilisateurs a été mis à jour avec succès.');
    }
}
