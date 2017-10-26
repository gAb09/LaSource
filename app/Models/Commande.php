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



    /**
     * Non implémentée.
     * Prévoit la possibilté de fixer des conditions avant qu'une livraison créée puisse être ouverte,
     * (par exemple qu'un nombre minimum de commandes soit atteint).
     *
     * @var array
     */
    public function checkIfOkForOuverture()
    {
        if (1 == 1) {
            return true;
        }
    }


    public function getStatutAttribute($value)
    {
        if ($value == '') {
            $newValue = "C_CREATED";
        }

        if ($this->checkIfOkForOuverture()) {
            $newValue = "C_REGISTERED";
        }

        /* date de clôture passée */
        if ($this->livraison()->find($this->livraison_id)->date_cloture->diffInDays(Carbon::now(), false) > 0) {
            $newValue = "C_CLOTURED";
        }

        /* date de paiement passée */
        if ($this->livraison()->find($this->livraison_id)->date_paiement->diffInDays(Carbon::now(), false) > 0) {
            if ($this->is_paid) {
                $newValue = 'C_PAID';
            }else{
                $newValue = 'C_NONPAID';
            }
        }

        /* date de livraison passée */
        if ($this->livraison()->find($this->livraison_id)->date_livraison->diffInDays(Carbon::now(), false) > 0) {
            if ($this->is_retired and $this->is_paid) {
                $newValue = 'C_ARCHIVABLE';
            }
            if (!$this->is_retired and $this->is_paid) {
                $newValue = 'C_OUBLIED';
            }
            if ($this->is_retired and !$this->is_paid) {
                $newValue = 'C_NONPAID';
            }
            if (!$this->is_retired and !$this->is_paid) {
                $newValue = 'C_SUSPECTED';
            }

        }

        if ($value == 'C_ARCHIVED') {
            $newValue = "C_ARCHIVED";
        }

        return $newValue;

    }
}