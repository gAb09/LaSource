<?php

namespace App\Domaines;

use App\Models\Livraison;

class Domaine
{
	protected $model;


	public function newModel()
	{
		return $this->model;
	}


	public function getSelfModelName()
	{
		$name = explode("\\", get_class($this->model));
		return strtolower(array_pop($name));
	}


	public function all($order = 'rang')
	{
		return $this->model->orderBy($order)->get();
	}


	public function allActifs($order = 'rang')
	{
		return $this->model->where('is_actif', 1)->orderBy($order)->get();
	}


	public function findFirst($critere, $colonne = 'id')
	{
		return $this->model->withTrashed()->where($colonne, $critere)->first();
	}


	public function destroy($id)
	{
		$this->model = $this->model->where('id', $id)->first();
		return $this->model->delete();
	}

	public function getDeleted()
	{
		return $this->model->onlyTrashed()->get();
	}

	public function setRangs($request)
	{
		$model_name = $this->getSelfModelName();
		$tablo = $request->get('tablo');
		foreach ($tablo as $doublet) {
			$id = $doublet[0];
			$rang = $doublet[1];

			if(! $model = $this->model->find($id)){
				return '<div class="alert alert-danger">'.trans("message.$model_name.setRangsFailed").'</div>';
			}
			$model->rang = $rang;
			$model->save();
		}
		return '<div class="alert alert-success">'.trans("message.$model_name.setRangsOk").'</div>';
	}

	/**
	* Contrôle s'il existe des livraisons liées
	* 
	* @return false|string
	**/
	public function checkIfLivraisonAttached($model_id, $action)
	{
		$model = $this->model->withTrashed()->with('livraison')->where('id', $model_id)->first();

		/* Si il existe au moins une livraison liée */
		if (!$model->livraison->isEmpty()) { 
			$model_name = $this->getSelfModelName();
			$message = "Oups !! $action impossible !<br />";
			foreach ($model->livraison as $livraison) {
				$message .= trans("message.$model_name.liedToLivraison", ['date' => $livraison->date_livraison_enClair]).'<br />';
			}
			return $message;
		}
		return false;
	}


	/**
	* Contrôle si le modèle est impliqué dans une livraison (contenu dans le pivot livraison/panier)
	* 
	* @return false|string
	**/
	public function checkIfImpliedInLivraison($model_id, $action)
	{
		$model_name = $this->getSelfModelName();
		$occurence = \DB::table('livraison_panier')->where($model_name, $model_id)->get();
// return dd($occurence);

		/* Si il existe au moins une livraison liée */
		if (!empty($occurence)) {
			$message = "Oups !! $action impossible !<br />";
			foreach ($occurence as $pivot) {
			$livraison = Livraison::where('id', $pivot->livraison_id)->first();
				$message .= trans("message.$model_name.liedToLivraison", ['date' => $livraison->date_livraison_enClair]).'<br />';
			}
			return $message;
		}
		return false;
	}

}