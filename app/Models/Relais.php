<?php

namespace App\Models;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relais extends Model
{
    use SoftDeletes, ModelTrait;
}
