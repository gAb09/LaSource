<?php

namespace App\Domaines;

// use App\Models\Mail;
use App\Domaines\Domaine;


class MailDomaine extends Domaine
{
	public function __construct(){
		$this->model = "MODEL";
	}

	public function Livraisons()
	{
		return 'mails pour les livraisons';
	}
}