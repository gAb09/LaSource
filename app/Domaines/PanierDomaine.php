<?php

namespace App\Domaines;

use App\Models\Panier;
use App\Domaines\Domaine;
use Illuminate\Http\Request;


class PanierDomaine extends Domaine
{
	protected $panier;


	public function __construct(){
		$this->panier = new Panier;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->panier->save();
	}

	public function update($id, $request){
		$this->panier = Panier::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->panier->save();
	}


	private function handleRequest($request){
		$this->panier->nom = $request->nom;
		$this->panier->nom_court = $request->nom_court;
		$this->panier->famille = $request->famille;
		$this->panier->type = $request->type;
		$this->panier->idee = $request->idee;
		$this->panier->prix_commun = $request->prix_commun;
		$this->panier->is_actif = (isset($request->is_actif)?1:0);
		$this->panier->remarques = $request->remarques;
	}

	public function listPaniers($livraison_id = null)
	{
		$items = $this->panier->with('Producteur', 'livraison')->where('is_actif', 1)->orderBy('type')->get();

		/* create */
		if ($livraison_id == null) { 
			return $items;
		}

		/* update */
		$items->each(function($item) use($livraison_id)
		{
			$item = $this->preparePaniersForView($item, $livraison_id);
		});
		return $items;
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

	public function findFirst($colonne, $critere)
	{
		return $this->panier->where($colonne, $critere)->first();
	}


	public function PanierSyncProducteurs($panier, $producteurs = array())
	{
		$item = Panier::find($panier);
		if(is_null($producteurs)){
			$item->producteur()->detach();
		}else{
			$item->producteur()->sync($producteurs);
		}
	}

	private function preparePaniersForView($item, $livraison_id)
	{
		$livraisons = $item->livraison;
		if(!empty($livraisons)){
			$livraisons->each(function($livraison) use($livraison_id, $item)
			{
				if ( $livraison->id == $livraison_id)
				{
					$item->lied = "lied";
				}
			});
		}

		return $item;
	}


}




