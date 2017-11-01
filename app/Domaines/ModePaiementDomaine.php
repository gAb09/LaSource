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


	/**
	* Update
	* 
	* @return boolean
	**/
	public function update($id, $request){
		return var_dump('update');
		if ($request->input('is_actived') == 0 and $this->hasLiaisonDirecteWithLivraison($id, 'Désactivation')) {
			return false;
		}

		$this->model = ModePaiement::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->is_actived = (isset($request->is_actived)?1:0);
		$this->model->remarques = $request->remarques;
		$this->model->rang = ($request->rang)? $request->rang : $this->model->max('rang')+1 ;
	}


	public function destroy($id)
	{
		if ($this->hasLiaisonDirecteWithLivraison($id, 'Suppression')) {
			return false;
		}
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		$this->model->livraison()->sync($aucun);
		
		return $this->model->delete();
	}

}