<?php

namespace App\Models;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Commande extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $appends = array('statut');

    private $state = "C_CREATED";



    public function lignes()
    {
        return $this->hasMany('App\Models\Ligne');
    }        


    public function livraison()
    {
        return $this->belongsTo('App\Models\Livraison');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function relais()
    {
        return $this->belongsTo('App\Models\Relais');
    }

    public function modePaiement()
    {
        return $this->belongsTo('App\Models\ModePaiement', 'modepaiement_id');
    }
}