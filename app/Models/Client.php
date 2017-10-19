<?php

namespace App\Models;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'prenom', 'nom',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $appends = array('class_actived');



    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function commandes()
    {
        return $this->hasMany('App\Models\Commande');
    }


    public function relais()
    {
        return $this->belongsTo('App\Models\Relais', 'pref_relais');
    }


    public function modePaiement()
    {
        return $this->belongsTo('App\Models\Relais', 'pref_mode');
    }


    public function getNomCompletAttribute($value)
    {
            return $this->prenom.' '.$this->nom;
        }

}
