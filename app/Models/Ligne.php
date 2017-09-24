<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    public function Commande()
    {
        return $this->belongsTo('App\Models\Commande');
    }

    public function Panier()
    {
        return $this->belongsTo('App\Models\Panier');
    }


    public function Producteur()
    {
        return $this->belongsTo('App\Models\Producteur');
    }


    public function getPrixFinalAttribute($value)
    {
        return (double) $value;
    }

    public function getMontantLigneAttribute($value)
    {
    	$value = $this->quantite*$this->prix_final;

        return $value;
    }

}
