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

	public function index()
	{
		return $this->model->orderBy('nom')->get();
	}


	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function update($id, $request){
		$this->model = ModePaiement::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}

	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->remarques = $request->remarques;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
	}

}