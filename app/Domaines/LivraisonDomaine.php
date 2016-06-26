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
		$this->model->date_cloture = $request->date_cloture;
		$this->model->date_paiement = $request->date_paiement;
		$this->model->date_livraison = $request->date_livraison;
		$this->model->remarques = $request->remarques;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		
	}

}
