<?php

namespace App\Domaines;

use App\Models\ModePaiement;
use App\Domaines\Domaine;


class ModePaiementDomaine extends Domaine
{
	public function __construct(){
		$this->model = new ModePaiement;
	}




	public function store($request){
		$this->handleRequest($request);

		try{
			$result = $this->model->save();
		}
		catch(\Illuminate\Database\QueryException $e){
			return dd($e);
		}
		return $result;
	}


	public function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->is_actived = (isset($request->is_actived)?1:0);
		$this->model->remarques = $request->remarques;
		$this->model->rang = ($request->rang)? $request->rang : $this->model->max('rang')+1 ;
	}


}