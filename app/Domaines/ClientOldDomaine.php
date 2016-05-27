<?php

namespace App\Domaines;

use App\ClientOld;


class ClientOldDomaine
{

	public function FindBy($Botte_foin, $aiguille)
	{
		return ClientOld::where($Botte_foin, $aiguille)->first();
	}
}