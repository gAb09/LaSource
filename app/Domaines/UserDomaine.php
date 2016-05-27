<?php

namespace App\Domaines;

use App\User;


class UserDomaine
{

	public function FindBy($Botte_foin, $aiguille)
	{
		return User::where($Botte_foin, $aiguille)->first();
	}
}