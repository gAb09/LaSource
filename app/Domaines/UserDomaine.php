<?php

namespace App\Domaines;

use App\Models\User;


class UserDomaine
{

	public function FindBy($colonne, $quoi)
	{
		return User::where($colonne, $quoi)->first();
	}
}