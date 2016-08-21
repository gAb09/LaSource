<?php

namespace App\Models;

use App\Models\ModelTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fermeture extends Model
{
	use ModelTrait;

    protected $dates = ['date_debut', 'date_fin'];

    public $timestamps = false;

    public function fermable()
    {
        return $this->morphTo();
    }

    public function getDateDebutEnclairAttribute($value)
    {
        $value = $this->date_debut;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }

    public function getDateFinEnclairAttribute($value)
    {
        $value = $this->date_fin;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }



}

