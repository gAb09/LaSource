<?php

namespace App\Domaines;

use App\Models\Relais;


class RelaisDomaine
{

	public function FindBy($colonne, $critere)
	{
		return Relais::where($colonne, $critere)->first();
	}

	static public function all($order)
	{
		return Relais::orderBy($order)->get();
	}
}