<?php

namespace App\Domaines;

use App\Models\User;


class UserDomaine
{

	public function FindBy($colonne, $critere)
	{
		return User::where($colonne, $critere)->first();
	}
}