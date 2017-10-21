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


}
