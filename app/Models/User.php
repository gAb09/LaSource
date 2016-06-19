<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'pseudo', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public function Client()
    {
        return $this->hasOne('App\Models\Client');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }

}
