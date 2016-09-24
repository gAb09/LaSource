<?php

namespace App\Models;


trait ModelTrait
{
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


    public function getClassActivedAttribute($value)
    {
        if ($this->is_actived == 1) {
            return 'is_actived';
        }
        return 'is_not_actived';
    }
}
