<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
         'nbr_jours', 'id_user', 'id_typeDemande', 'id_status'
    ];
    protected $dates = ['date_debut', 'date_fin'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function typeDemande()
    {
        return $this->belongsTo(TypeDemande::class, 'id_typeDemande');
    }

    public function statusDemande()
    {
        return $this->belongsTo(StatusDemande::class, 'id_status');
    }
}
