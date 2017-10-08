<?php

namespace App\Domaines;

use App\Models\Ligne;
use App\Domaines\Domaine;


class LigneDomaine extends Domaine
{
	public function __construct(){
		$this->model = new Ligne;
	}

	/**
	 * • Effectuer une requete sur la table livraison_panier pour obtenir producteur et prix livraison associés à ce colis.
	 *
	 * @param integer : id de la livraison concernée
	 * @param integer : id du panier concerné
	 *
	 * @return Array ['producteur, 'prix_livraison]
	 **/
	public function completeLignes($livraison_id, $panier_id){

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

		return $models[0];
	}



}