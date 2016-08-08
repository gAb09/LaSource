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


    public function Livraison()
    {
        return $this->belongsToMany('App\Models\Livraison')->withPivot('indisponible', 'motif');
    }


}