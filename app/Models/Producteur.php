<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producteur extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $appends = array('class_actif');

    private function formatTel($value)
    {
    	$value = str_split($value, 2);
    	$value = implode(' ', $value);
    	return $value;
    }

    public function getMobileAttribute($value)
    {
        return $this->formatTel($value);
    }

    public function getClassActifAttribute($value)
    {
        if ($this->is_actif == 1) {
            return 'is_actif';
        }
        return 'is_not_actif';
    }

    public function getTelAttribute($value)
    {
    	return $this->formatTel($value);
    }
}