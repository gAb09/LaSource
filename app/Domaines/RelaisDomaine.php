<?php

namespace App\Domaines;

use App\Models\Relais;
use App\Domaines\Domaine;


class RelaisDomaine extends Domaine
{
	protected $model;
	protected $livraisonD;
	protected $liv_concerned;

	public function __construct(LivraisonDomaine $livraisonD){
		$this->model = new Relais;
		$this->livraisonD = $livraisonD;
	}



	public function index(){
		return $models = $this->model->with('indisponibilites')->get();;
	}


	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}


	public function update($id, $request){
		if ($request->input('is_actived') == 0 and $this->checkIfLiaisonDirecteWithLivraison($id, 'Désactivation')) {
			return false;
		}

		$this->model = Relais::withTrashed()->where('id', $id)->first();
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
		$this->model->is_actived = (isset($request->is_actived)?1:0);
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;
		$this->model->restore();
	}

	public function destroy($id)
	{
		if ($this->checkIfLiaisonDirecteWithLivraison($id, 'Suppression')) {
			return false;
		}

		$this->model = $this->model->where('id', $id)->first();
		
		return $this->model->delete();
	}

	public function ListForLivraisonEdit($livraison_id){
		$items = $this->model->with(['indisponibilites' => function ($query) {
			$query->oldest('date_debut');
		}, 'livraison'])
		->where('is_actived', 1)
		->orderBy('rang')->get();

		$this->liv_concerned = $this->livraisonD->findFirst($livraison_id);

		$items = $items->each(function ($item) {
			if (!$item->indisponibilites->isEmpty()) {
				foreach ($item->indisponibilites as $key => $indisponibilite) {
					$item = $this->setIfIndispoForAllDates($item, $key, $indisponibilite);
					$item = $this->setIfIndispoForDateLivraison($item, $key, $indisponibilite);
				}
			}

			$item = $this->setIsLied($item);
		});
		return $items;
	}


	private function setIfIndispoForDateLivraison($item, $key, $indisponibilite){
		if ($this->liv_concerned->date_livraison->between($indisponibilite->date_debut, $indisponibilite->date_fin)) {
			$item->indisponibilites[$key]->statut = 'IndispoPourLivraison';
			$item->statut = 'IndispoPourLivraison';
		}
		return $item;
	}


	private function setIfIndispoForAllDates($item, $key, $indisponibilite){
		if ($indisponibilite->date_debut->between($this->liv_concerned->date_cloture, $this->liv_concerned->date_livraison)
			or
			$indisponibilite->date_fin->between($this->liv_concerned->date_cloture, $this->liv_concerned->date_livraison))
		{
			$item->indisponibilites[$key]->statut = 'IndispoGlobal';
			$item->statut = 'IndispoGlobal';
		}
		return $item;
	}


	private function setIsLied($item){
		if ($item->livraison->isEmpty()){
			$item->is_lied = 0;
			$item->liaison = 'empty';
			return $item;
		}

		if ($item->statut == 'IndispoPourLivraison') {
			$item->is_lied = 0;
			$item->liaison = 'IndispoPourLivraison';
			return $item;
		}

		foreach ($item->livraison as $livraison) {
			if ($this->liv_concerned->id == $livraison->id) {
				$item->is_lied = 1;
				$item->liaison = 'lié';
				return $item;
			}else{
				$item->is_lied = 0;
				$item->liaison = 'non lié';
			}
		}
		return $item;
	}

}