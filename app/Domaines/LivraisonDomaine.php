<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\Domaine;


class LivraisonDomaine extends Domaine
{
	protected $model;

	public function __construct(){
		$this->model = new Livraison;
	}

	public function index()
	{
		return $this->model->orderBy('id', 'desc')->get();
	}


	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function update($id, $request){
		$this->model = Livraison::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}

	private function handleRequest($request){
		// $this->model->exploitation = $request->exploitation;
		// $this->model->nom = $request->nom;
		// $this->model->prenom = $request->prenom;
		// $this->model->ad1 = $request->ad1;
		// $this->model->ad2 = $request->ad2;
		// $this->model->cp = $request->cp;
		// $this->model->ville = $request->ville;
		// $this->model->tel = $this->model->cleanTel($request->tel);
		// $this->model->mobile = $this->model->cleanTel($request->mobile);
		// $this->model->email = $request->email;
		// $this->model->nompourpaniers = $request->nompourpaniers;
		// $this->model->is_actif = (isset($request->is_actif)?1:0);
		
		return $this->model->save();
	}

}