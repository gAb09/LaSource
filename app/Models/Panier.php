<?php

namespace App\Models;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Panier extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $appends = array('class_actived');

    public function Producteur()
    {
        return $this->belongsToMany('App\Models\Producteur');
    }

    public function Livraison()
    {
        return $this->belongsToMany('App\Models\Livraison')->withPivot('producteur', 'prix_livraison');
    }


}