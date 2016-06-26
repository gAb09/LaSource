<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModePaiement extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
