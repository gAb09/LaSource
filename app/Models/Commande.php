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

    protected $appends = array('state');

    private $state = "C_CREATED";



    public function Lignes()
    {
        return $this->hasMany('App\Models\Ligne');
    }


    public function Livraison()
    {
        return $this->belongsTo('App\Models\Livraison');
    }



    public function getStateAttribute($value)
    {
    	$livraison = $this->with('Livraison')->where('id', $this->id)->first()->livraison;

    	$value = "C_CREATED";

    	if ($this->checkIfOkForRegister()) {
    		$value = "C_REGISTERED";
    	}

    	if ($livraison->date_paiement->diffInDays(Carbon::now(), false) > 0) {
    		if ($this->is_paid) {
    			$value = "C_VALIDED";
    		}else{
    			$value = "C_NONPAID";
    		}
    	}


    	if ($livraison->date_livraison->diffInDays(Carbon::now(), false) > 0) {
    		if ($this->is_paid) {
    			if ($this->is_retired) {
    				$value = "C_ARCHIVABLE";
    			}else{
    				$value = "C_OUBLIED";
    			}
    		}else{
    			if ($this->is_retired) {
    				$value = "C_NONPAID";
    			}else{
    				$value = "C_SUSPECTED";
    			}
    		}
    	}


        if ($this->is_archived) {
            $value = 'C_ARCHIVED';
        }

        return $value;
    }


    /**
     * Non implémentée.
     * Prévoit la possibilté de fixer des conditions avant qu'une commande créée puisse être enregistrée,
     * (par exemple qu'un nombre minimum de commandes soit atteint).
     *
     * @var array
     */
    public function checkIfOkForRegister()
    {
        if (1==1) {
            return true;
        }
    }



}