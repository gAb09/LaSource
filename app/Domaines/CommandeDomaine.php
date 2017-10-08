<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class CommandeDomaine extends Domaine
{

	private $montant_ligne = 0;

	public function __construct(){
		$this->model = new Commande;
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
	public function index($pages){
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->orderBy('id', 'DESC')->paginate($pages);

		$commandes->each(function ($commande, $keys) {
			$commande->lignes->each(function ($ligne, $keys) use($commande){
				$ligne->complement = $this->completeLignes($commande->livraison_id, $ligne->panier_id);
			});
		});
		return $commandes;
	}


	/**
	 * • Effectuer une requete sur la table livraison_panier pour obtenir producteur et prix livraison associés à ce colis.
	 *
	 * @param integer : id de la livraison concernée
	 * @param integer : id du panier concerné
	 *
	 * @return Array ['producteur, 'prix_livraison]
	 **/
	private function completeLignes($livraison_id, $panier_id){

		$models = \DB::table('livraison_panier')

		// Producteur
		->leftjoin('producteurs', function ($join) {
			$join->on('producteurs.id', '=', 'livraison_panier.producteur');
		})
		->where([['livraison_id', '=', $livraison_id], ['panier_id', '=', $panier_id]])
		->select(
			'livraison_panier.producteur', 'livraison_panier.prix_livraison' // Pivot livraison_panier
			, 'producteurs.exploitation as producteur' // Producteur
			)
		->get();

		return $models;
	}

}