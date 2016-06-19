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
		$this->model = Relais::where('id', $id)->first();
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
	}
}