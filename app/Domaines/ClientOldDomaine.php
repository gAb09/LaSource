<?php

namespace App\Domaines;

use App\Models\ClientOld;


class ClientOldDomaine
{

	public function FindBy($colonne, $quoi)
	{
		return ClientOld::where($colonne, $quoi)->first();
	}
}