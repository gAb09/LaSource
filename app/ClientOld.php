<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ClientOld extends Authenticatable
{
    protected $table = 'paniers_clients';
	protected $primaryKey = 'id_client';
    public $timestamps = false;
    protected $connection = 'mysql_old';
}
