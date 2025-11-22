<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use HasFactory;

    protected $fillable = ['age'];

    public function users()
    {
        return $this->hasMany(User::class, 'age_id');
    }
}


