<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFonctionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['nomFr','nomAr'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}