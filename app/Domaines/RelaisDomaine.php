<?php

namespace App\Domaines;

use App\Models\Relais;
use App\Domaines\Domaine;


class RelaisDomaine extends Domaine
{
	protected $model;

	public function __construct(){
		$this->model = new Relais;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function update($id, $request){
		if ($request->input('is_actif') == 0 and $result = $this->checkIfLivraisonLied($id, 'Désactivation')) {
			return($result);
		}

		$this->model = Relais::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}

	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->retrait = $request->retrait;
		$this->model->ad1 = $request->ad1;
		$this->model->ad2 = $request->ad2;
		$this->model->cp = $request->cp;
		$this->model->ville = $request->ville;
		$this->model->tel = $this->model->cleanTel($request->tel);
		$this->model->email = $request->email;
		$this->model->ouvertures = $request->ouvertures;
		$this->model->remarques = $request->remarques;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
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
		
		return $this->model->delete();
	}

}