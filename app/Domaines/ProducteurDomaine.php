<?php

namespace App\Domaines;

use App\Models\Producteur;
use App\Domaines\Domaine;


class ProducteurDomaine extends Domaine
{
	use ActivableDomaineTrait;

	public function __construct(){
		$this->model = new Producteur;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	protected function handleRequest($request){
		$this->model->exploitation = $request->exploitation;
		$this->model->nom = $request->nom;
		$this->model->prenom = $request->prenom;
		$this->model->ad1 = $request->ad1;
		$this->model->ad2 = $request->ad2;
		$this->model->cp = $request->cp;
		$this->model->ville = $request->ville;
		$request->tel = str_replace('.', '', $request->tel);
		$request->tel = str_replace(' ', '', $request->tel);
		$this->model->tel = $request->tel;
		$request->mobile = str_replace('.', '', $request->mobile);
		$request->mobile = str_replace(' ', '', $request->mobile);
		$this->model->mobile = $request->mobile;
		$this->model->email = $request->email;
		$this->model->nompourpaniers = $request->nompourpaniers;
		$this->model->remarques = $request->remarques;
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;
		$this->model->restore();
	}



	public function listProducteursForPanier($panier_id)
	{
		$collection = $this->model->with('Panier')->where('is_actived', 1)->orderBy('nompourpaniers')->get();

		$collection->each(function($model) use($panier_id)
		{
			$paniers = $model->panier;
			if(!empty($paniers))
			{
				$paniers->each(function($panier) use($panier_id, $model)
				{
					if ( $panier->id == $panier_id)
					{
						$model->lied = "lied";
						$this->titre_page = $panier->nom_court;
					}
				});
			}
		});

		return $collection;
	}

  /**
  * undocumented function
  *
  * @return void
  * @author 
  **/
  public function getRapportDashboard($livraison)
  {
  	$model = \DB::table('livraison_panier')->where('livraison_id', $livraison)
  	->leftjoin('producteurs', function ($join) {
  		$join->on('producteurs.id', '=', 'livraison_panier.producteur_id');
  	}) 
  	->get();

  	/* Composition des lignes pour chaque panier (eux-mêmes complétés) */
    // $model = $this->composeLignesPaniersForRapportLivraison($livraison, $livraison->relais);

  	// return dd($model);
  	return $model;
  }

}