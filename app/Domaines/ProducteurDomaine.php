<?php

namespace App\Domaines;

use App\Models\Producteur;


class ProducteurDomaine
{

	public function FindBy($colonne, $critere)
	{
		return Producteur::where($colonne, $critere)->first();
	}

	static public function all($order)
	{
		return Producteur::orderBy($order)->get();
	}
}