<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;

    protected $fillable = ['nom_enfant', 'date_naissance', 'age16', 'scolaire', 'handicap', 'id_user','prenom_enfant'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
