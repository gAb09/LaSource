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


    public function getPrixLivraisonAttribute($value)
    {
        if (!isset($this->complement)) {
            $value = NULL;
        }else{
            $value = $this->complement->prix_livraison;
        }
        return $value;
    }

    public function getMontantLigneAttribute($value)
    {
        $value = $this->quantite*$this->prix_livraison;

        return $value;
    }

}
