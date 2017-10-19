<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModePaiement extends Model
{
    use SoftDeletes, ModelTrait;

    protected $table = 'modepaiements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];


    public function livraison()
    {
        return $this->belongsToMany('App\Models\Livraison')->withPivot('motif');
    }


    public function indisponibilites()
    {
        return $this->morphMany('App\Models\Indisponibilite', 'indisponisable');
    }


}