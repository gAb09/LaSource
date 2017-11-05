<?php

namespace App\Domaines;

use App\Models\Panier;
use App\Domaines\Domaine;
use Illuminate\Http\Request;


class PanierDomaine extends Domaine
{
	use ActivableDomaineTrait;

	public function __construct(){
		$this->model = new Panier;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}


	protected function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->nom_court = $request->nom_court;
		$this->model->famille = $request->famille;
		$this->model->type = $request->type;
		$this->model->idee = $request->idee;
		$this->model->prix_base = $request->prix_base;
		$this->model->is_actived = (isset($request->is_actived)?1:0);
		$this->model->remarques = $request->remarques;
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;

	}



    /**
    * Obtention des paniers liés à la livraison concernée,
    * avec gestion de l'affichage des données de pivot livraison/panier :
    * – producteur,
    * – prix_livraison.
    *
    * @param integer $livraison_id
    * @return Collection de App\Models\Panier
    **/
	public function ListForLivraisonEdit($livraison_id)
	{

		$paniers_lied = $this->model->whereHas('livraison', function ($query) use($livraison_id){
			$query->where('livraison_id', $livraison_id);
		})->with('producteur')->where('is_actived', 1)->get();

		foreach ($paniers_lied as $panier) {
			$producteur = $panier->livraison->find($livraison_id)->pivot->producteur;
			if(is_null($producteur) ){
				if(!empty(old('producteur.'.$panier->id))){
					$panier->producteur = old('producteur.'.$panier->id);
				}else{
					$panier->producteur_id = 0;
				}
			}else{
				$panier->producteur_id = $producteur;
			}

			$prix_livraison = $panier->livraison->find($livraison_id)->pivot->prix_livraison;
			if(is_null($prix_livraison) ){
				if(!empty(old('prix_livraison.'.$panier->id))){
					$panier->prix_livraison = old('prix_livraison.'.$panier->id);
				}else{
					$panier->prix_livraison = 0;
				}
			}else{
				$panier->prix_livraison = $prix_livraison;
			}
		}

		return $paniers_lied;
	}



    /**
    * Obtention d'une liste de tous les paniers pour attachement/détachement avec la livraison concernée,
    * avec pour chaque panier :
    * – réécriture de son nom.
    * – détection si déjà lié ou non.
    *
    * @param integer $livraison_id
    * @return Object View
    **/
	public function getAllPaniersForLivraisonSynchronisation($livraison_id)
	{
		$models = $this->model->with('Producteur', 'livraison')->where('is_actived', 1)->orderBy('type')->get();

		$models->each(function($model) use($livraison_id)
		{
			$model->nom = str_replace(['<br />', '<br/>'], " - ", $model->nom);
			$model = $this->checkIfPanierIsLied($model, $livraison_id);
		});
		return $models;
	}



    /**
    * Détection si un panier est déjà déjà lié ou non à la livraison concernée.
    *
    * @param App\Models\Panier $model
    * @param integer $livraison_id
    * @return App\Models\Panier
    **/
	private function checkIfPanierIsLied($model, $livraison_id)
	{
		$livraisons = $model->livraison;
		if(!empty($livraisons)){
			$livraisons->each(function($livraison) use($livraison_id, $model)
			{
				if ( $livraison->id == $livraison_id)
				{
					$model->lied = "lied";
				}
			});
		}

		return $model;
	}


	public function PanierSyncProducteurs($panier_id, $producteurs = array())
	{
		$model = Panier::find($panier_id);
		if(is_null($producteurs)){
			$model->producteur()->detach();
		}else{
			$model->producteur()->sync($producteurs);
		}
	}
}




