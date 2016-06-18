<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'prenom', 'nom',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];



    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function cleanTel($value)
    {
        $value = str_replace(' ', '', $value);
        $value = str_replace('.', '', $value);
        return $value;
    }


    public function formatTel($value)
    {
        $value = str_split($value, 2);
        $value = implode(' ', $value);
        return $value;
    }


    public function getMobileAttribute($value)
    {
        return $this->formatTel($value);
    }


    public function getTelAttribute($value)
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

}
