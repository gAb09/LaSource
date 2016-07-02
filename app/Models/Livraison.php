<?php

namespace App\Models;

use App\Models\ModelTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livraison extends Model
{
	use SoftDeletes, ModelTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date_paiement', 'date_cloture', 'date_livraison'];

    protected $appends = array('class_actif');


}