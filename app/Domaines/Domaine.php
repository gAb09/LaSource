<?php

namespace App\Domaines;


class Domaine
{
	protected $model;

	public function newModel()
	{
		return $this->model;
	}


	public function getModelName()
	{
		$name = explode("\\", get_class($this->model));
		return lcfirst(array_pop($name));
	}


	public function all($order = 'id')
	{
		return $this->model->orderBy($order)->get();
	}


	public function allActifs($order = 'id')
	{
		return $this->model->where('is_actif', 1)->orderBy($order)->get();
	}


	public function findFirst($colonne, $critere)
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
		$model_name = $this->getModelName();
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

}