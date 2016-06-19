<?php

namespace App\Domaines;

use App\Models\Producteur;


class Domaine
{

	public function newModel()
	{
		return $this->model;
	}


	public function all($order = 'id')
	{
		return $this->model->orderBy($order)->get();
	}


	public function allActifs()
	{
		return $this->model->where('is_actif', 1)->get();
	}


	public function findFirst($colonne, $critere)
	{
		return $this->model->where($colonne, $critere)->first();
	}


	public function destroy($id)
	{
		$this->model = $this->model->where('id', $id)->first();
		return $this->model->delete();
	}
}