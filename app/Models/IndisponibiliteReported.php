<?php

namespace App\Models;

use App\Models\ModelTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndisponibiliteReported extends Model
{
	use ModelTrait;

    protected $table = 'indisponibilites_reported';

    protected $dates = ['prev_date_debut', 'prev_date_fin'];

    public $timestamps = false;


    public function getPrevDateDebutEnclairAttribute($value)
    {
        $value = $this->prev_date_debut;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }

    public function getPrevDateFinEnclairAttribute($value)
    {
        $value = $this->prev_date_fin;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }



}

