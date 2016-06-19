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

	public function FindFirst($colonne, $critere)
	{
		return $this->model->where($colonne, $critere)->first();
	}

	public function destroy($id)
	{
		$this->model = $this->model->where('id', $id)->first();
		return $this->model->delete();
	}

}