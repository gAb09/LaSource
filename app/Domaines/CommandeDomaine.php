<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;


class CommandeDomaine extends Domaine
{
	public function __construct(){
		$this->model = new Commande;
	}


	public function index($pages = 5)
	{
		return $this->model->with('livraison', 'client', 'lignes.panier', 'lignes.producteur' )->orderBy('id', 'desc')->paginate($pages);
	}

}