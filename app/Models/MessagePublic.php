<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagePublic extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id','sender_name', 'message'];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
