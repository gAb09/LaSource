<?php

namespace App\Domaines;

use App\Models\Panier;
use App\Domaines\Domaine;


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
		$this->model = Panier::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->nom_court = $request->nom_court;
		$this->model->famille = $request->famille;
		$this->model->type = $request->type;
		$this->model->idee = $request->idee;
		$this->model->prix_commun = $request->prix_commun;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		$this->model->remarques = $request->remarques;
		return $this->model->save();
	}

}