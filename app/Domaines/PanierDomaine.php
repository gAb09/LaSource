<?php

namespace App\Domaines;

use App\Models\Panier;
use App\Domaines\Domaine;
use Illuminate\Http\Request;


class PanierDomaine extends Domaine
{
	protected $model;


	public function __construct(){
		$this->model = new Panier;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function update($id, $request){

		if ($request->input('is_actif') == 0 and $message = $this->checkIfLivraisonAttached($id, 'Désactivation')) {
			return($message);
		}

		$this->model = Panier::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->nom_court = $request->nom_court;
		$this->model->famille = $request->famille;
		$this->model->type = $request->type;
		$this->model->idee = $request->idee;
		$this->model->prix_base = $request->prix_base;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		$this->model->remarques = $request->remarques;
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;
		$this->model->restore();

	}

	public function destroy($id)
	{
		if ($message = $this->checkIfLivraisonAttached($id, 'Suppression')) {
			return($message);
		}
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		$this->model->producteur()->sync($aucun);
		
		return $this->model->delete();
	}


	public function listPaniers($livraison_id = null)
	{
		$models = $this->model->with('Producteur', 'livraison')->where('is_actif', 1)->orderBy('type')->get();

		/* livraison.create */
		if ($livraison_id == null) { 
			return $models;
		}

		/* livraison.update */
		$models->each(function($model) use($livraison_id)
		{
			$model->nom = str_replace(['<br />', '<br/>'], " - ", $model->nom);
			$model = $this->preparePaniersForView($model, $livraison_id);
		});
		return $models;
	}

	public function paniersChoisis($livraison_id = null)
	{

		$panierschoisis = Panier::whereHas('livraison', function ($query) use($livraison_id){
			$query->where('livraison_id', $livraison_id);
		})->with('producteur')->where('is_actif', 1)->get();

		foreach ($panierschoisis as $panier) {
			$producteur = $panier->livraison->find($livraison_id)->pivot->producteur;
			if(is_null($producteur) ){
				if(!empty(old('producteur.'.$panier->id))){
					$panier->prod_value = old('producteur.'.$panier->id);
				}else{
					$panier->prod_value = 0;
				}
			}else{
				$panier->prod_value = $producteur;
			}

			$prix_livraison = $panier->livraison->find($livraison_id)->pivot->prix_livraison;
			if(is_null($prix_livraison) ){
				if(!empty(old('prix_livraison.'.$panier->id))){
					$panier->liv_value = old('prix_livraison.'.$panier->id);
				}else{
					$panier->liv_value = 0;
				}
			}else{
				$panier->liv_value = $prix_livraison;
			}
		}

		return $panierschoisis;
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

	private function preparePaniersForView($model, $livraison_id)
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

}




