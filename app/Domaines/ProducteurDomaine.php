<?php

namespace App\Domaines;

use App\Models\Producteur;


class ProducteurDomaine
{

	public function FindBy($colonne, $quoi)
	{
		return Producteur::where($colonne, $quoi)->first();
	}

	static public function all($order)
	{
		return Producteur::orderBy($order)->get();
	}
}