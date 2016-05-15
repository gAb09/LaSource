<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientOld extends Model
{
    protected $table = 'paniers_clients';
	protected $primaryKey = 'id_client';
    public $timestamps = false;
    protected $connection = 'mysql_old';
}
