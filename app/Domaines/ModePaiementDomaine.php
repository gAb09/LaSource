<?php

namespace App\Domaines;

use App\Models\ModePaiement;
use App\Domaines\Domaine;


class ModePaiementDomaine extends Domaine
{
	protected $model;

	public function __construct(){
		$this->model = new ModePaiement;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function update($id, $request){

		if ($request->input('is_actif') == 0 and $result = $this->checkIfLivraisonLied($id, 'Désactivation')) {
			return($result);
		}

		$this->model = ModePaiement::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}

	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		$this->model->remarques = $request->remarques;
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;
		$this->model->restore();
	}

	public function destroy($id)
	{
		if ($result = $this->checkIfLivraisonLied($id, 'Suppression')) {
			return($result);
		}
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		$this->model->livraison()->sync($aucun);
		
		return $this->model->delete();
	}


}