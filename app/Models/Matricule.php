<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricule extends Model
{
    use HasFactory;
    protected $fillable = ['numero'];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
