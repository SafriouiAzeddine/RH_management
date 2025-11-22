<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nomFr', 'nomAr', 'prenomFr', 'prenomAr', 'email', 'password', 'photo','solde_conger', 'role',
        'nomPereFr', 'nomPereAr', 'nomMereFr', 'nomMereAr', 'lieu_naissance', 'date_naissance', 'CINE', 'filiere',
        'id_matricule', 'id_role', 'id_grade', 'id_division', 'id_service','is_congé', 'id_status','CNOPS', 'date_service', 'numeroPPR',
         'date_grade', 'date_echellon', 'mission_respo','local', 'mutuelle', 'solde_conger','age_id', 'category_fonctionnaire_id','status',
         'last_activity_at','google_id',
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function matricule()
    {
        return $this->belongsTo(Matricule::class, 'id_matricule');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');//!!!!!!role==id_role!!!pour acceder le nom du role il faut $user->roles->role et pour access id du role il faut $user->role et non id_role
        //id_role faut channger de la db


    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'id_grade');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'id_division');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function statusFonctionnaire()
    {
        return $this->belongsTo(StatusFonctionnaire::class, 'id_status');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'id_user');
    }

    public function maries()
    {
        return $this->hasMany(Marie::class, 'id_user');
    }

    public function enfants()
    {
        return $this->hasMany(Enfant::class, 'id_user');
    }

    public function fichierNotes()
    {
        return $this->hasMany(FichierNote::class, 'id_user');
    }
    public function age()
    {
        return $this->belongsTo(Age::class,'age_id');
    }

    public function categoryFonctionnaire()
    {
        return $this->belongsTo(CategoryFonctionnaire::class);
    }
}