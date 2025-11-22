<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nomFr', 'nomAr', 'id_division'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'id_division');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_service');
    }
}
