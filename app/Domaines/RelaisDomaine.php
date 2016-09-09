<?php

namespace App\Domaines;

use App\Models\Relais;
use App\Domaines\Domaine;


class RelaisDomaine extends Domaine
{
	protected $model;
	protected $livraisonD;

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
		if ($request->input('is_actived') == 0 and $message = $this->checkIfLivraisonAttached($id, 'Désactivation')) {
			return($message);
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
		if ($message = $this->checkIfLivraisonAttached($id, 'Suppression')) {
			return($message);
		}
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		
		return $this->model->delete();
	}

	public function ListForLivraisonEdit($livraison_id){
		$items = $this->model->with(['indisponibilites' => function ($query) {
			$query->oldest('date_debut');
		}], 'livraison')
		->where('is_actived', 1)
		->orderBy('rang')->get();

		$this->livconcerned = $this->livraisonD->findFirst($livraison_id);

		$items = $items->each(function ($item) {
			if (!$item->indisponibilites->isEmpty()) {
				foreach ($item->indisponibilites as $key => $indisponibilite) {
					$item = $this->checkAllDates($item, $key, $indisponibilite);
					$item = $this->checkDateLivraison($item, $key, $indisponibilite);
				}
			}

			$item = $this->checkLiedWIthThisLivraison($item);
		});
		return $items;
	}


	private function checkDateLivraison($item, $key, $indisponibilite){
		if ($this->livconcerned->date_livraison->between($indisponibilite->date_debut, $indisponibilite->date_fin)) {
			$item->indisponibilites[$key]->statut = 'IndispoPourLivraison';
			$item->statut = 'IndispoPourLivraison';
		}
		return $item;
	}


	private function checkAllDates($item, $key, $indisponibilite){
		if ($indisponibilite->date_debut->between($this->livconcerned->date_cloture, $this->livconcerned->date_livraison)
			or
			$indisponibilite->date_fin->between($this->livconcerned->date_cloture, $this->livconcerned->date_livraison))
		{
			$item->indisponibilites[$key]->statut = 'IndispoGlobal';
			$item->statut = 'IndispoGlobal';
		}
		return $item;
	}


	private function checkLiedWIthThisLivraison($item){
		if ($item->livraison->isEmpty()){
			$item->is_lied = 0;
			return $item;
		}

		if ($item->statut == 'IndispoPourLivraison') {
			$item->is_lied = 0;
			return $item;
		}

		foreach ($item->livraison as $livraison) {
			if ($this->livconcerned->id == $livraison->id) {
				if ($livraison->pivot->is_retired == 1) {
					$item->is_lied = 0;
					$item->is_retired = 1;
					return $item;
				}else{
					$item->is_lied = 1;
					$item->is_retired = 0;
					return $item;
				}
			// }else{
			// 	return $item;
			}
		}

		$item->is_lied = 6;
		return $item;
	}

}