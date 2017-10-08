<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domaines\LigneDomaine;

class CommandeDomaine extends Domaine
{

	private $montant_ligne = 0;

	public function __construct(LigneDomaine $lignesD){
		$this->model = new Commande;
		$this->lignesD = $lignesD;
	}


	/**
	 *
	 * @param Integer : nombre de commandes par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function index($pages){
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->orderBy('id', 'DESC')->paginate($pages);

		$commandes = $this->getAllLignes($commandes);

		return $commandes;

	}


	/**
	 * • Effectuer une requete des commandes avec ses relations, y compris les lignes avec leur relation panier pour le nom en clair de celui-ci.
	 * • Pour chaque lignes en effectuer le complément (obtention du producteur associé au panier et son prix_livraison.
	 * + pagination
	 *
	 * @param Integer : nombre de commandes par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	function getAllLignes($commandes)
	{
		$commandes = $commandes;
		$commandes->each(function ($commande, $keys) {

			$commande->lignes->each(function ($ligne, $keys) use($commande){
				$ligne->complement = $this->lignesD->completeLignes($commande->livraison_id, $ligne->panier_id);

			});
			// return dd($commande);
		});

		return $commandes;
		// return dd($commandes);

	}


}