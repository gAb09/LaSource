<?php

namespace App\Domaines;

use App\Models\Relais;


class RelaisDomaine
{

	public function FindBy($colonne, $quoi)
	{
		return Relais::where($colonne, $quoi)->first();
	}

	static public function all($order)
	{
		return Relais::orderBy($order)->get();
	}
}