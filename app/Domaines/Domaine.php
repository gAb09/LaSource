<?php

namespace App\Domaines;

use App\Models\Livraison;
use Gab\Helpers\DateFr;

class Domaine
{
    /**
    * Le modèle courant. Nouveau modèle vide créé à la construction, peut être assigné par la suite.
    **/
	protected $model;


    /**
    * Le titre de la prochaine page à afficher.
    * Dispose d'un accesseur à l'attention des controleurs
    **/
    protected $titre_page;


    /**
    * Le message utilisateur de la prochaine page à afficher.
    * Dispose d'un accesseur à l'attention des controleurs
    **/
    protected $message;




    /**
    * Accesseur model.
    * 
    * @return string
    **/
    public function getCurrentModel(){  // ToDo ajouter if(!isset($this->model)) {$this->model = new Static} ??
        return $this->model;
    }


    /**
    * Accesseur de $titre_page.
    * 
    * @return string
    **/
    public function getTitrePage(){
        return $this->titre_page;
    }



    /**
    * Accesseur message.
    * 
    * @return string
    **/
    public function getMessage(){
        return $this->message;
    }



    /**
    * Obtention du nom du model courant en minuscules.
    * 
    * @return string
    **/
	public function getDomaineName()
	{
		$name = explode("\\", get_class($this->model));
		return strtolower(array_pop($name));
	}



	public function all($order = 'rang')
	{
		return $this->model->orderBy($order)->get();
	}



	public function allActived($order = 'rang')
	{
		return $this->model->where('is_actived', 1)->orderBy($order)->get();
	}



	public function allActivedIdForSyncLivraison()
	{
		$test = $this->model->where('is_actived', 1)->get(['id']);
		$data = array();
		foreach ($test as $item) {
			$data[] = $item['id'];
		}
		return $data;
	}



	public function findFirst($critere, $colonne = 'id')
	{
		return $this->model->where($colonne, $critere)->first();
	}


	public function findFirstWithTrashed($critere, $colonne = 'id')
	{
		return $this->model->withtrashed()->where($colonne, $critere)->first();
	}



	public function destroy($id)
	{
		$this->model = $this->model->where('id', $id)->first();
		return $this->model->delete();
	}


	/**
	* Obtention des models soft deleted seulement.
	*
	* @return collection of current models
	**/
	public function getDeleted()
	{
		return $this->model->onlyTrashed()->get();
	}



	/**
	* Persistence du rang du model courant après glisser-déposer dans la vue.
	*
	* @param Request
	*
	* @return string (message d'échec ou de réussite)
	**/
	public function setRangs($request)
	{
		$model_name = $this->getDomaineName();
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
	* Pour une entité liée aux livraisons via une table pivot,
	* contrôle de l'existence d'une liaison pour ce modèle.
	* 
	* @return boolean  true si liaison | false sinon
	**/
	public function hasLiaisonDirecteWithLivraison($model_id, $action)
	{
		return ($this->model);
		$this->model = $this->model->withTrashed()->with('livraison')->where('id', $model_id)->first();
		/* Si il existe au moins une livraison non archivée liée */
		if (!$this->model->livraison->isEmpty()) {
			$this->setMessageLiaisonDirecteWithLivraison($action);
			return true;
		}else{
			return false;
		}
	}



	/**
	* Construction du mesage précisant la ou les liaisons directes.
	* 
	* @param string $action
	**/
	public function setMessageLiaisonDirecteWithLivraison($action)
	{
		$model_name = $this->getDomaineName();
		$message = "Oups !! $action impossible !<br />";
		foreach ($this->model->livraison as $livraison) {
			if($livraison->statut != 'L_ARCHIVED'){
				$message .= trans("message.$model_name.liedToLivraison", ['date' => DateFr::complete($livraison->date_livraison)]).'<br />';
			}
		}
		$this->message = $message;
	}



	/**
	* Contrôle si le modèle est impliqué dans une livraison (contenu dans le pivot livraison/panier)
	* 
	* @return false|string
	**/
	public function checkIfLiaisonIndirecteWithLivraison($model_id, $action)
	{
		$model_name = $this->getDomaineName();
		$occurence = \DB::table('livraison_panier')->where($model_name, $model_id)->get();
		// return dd($occurence);

		if (!empty($occurence)) {
			$this->message = $this->setMessageLiaisonIndirecteWithLivraison($action, $occurence);
			return true;
		}else{
			return false;
		}
	}


	/**
	* Construction du message précisant la ou les liaisons indirectes..
	* 
	* @return string
	**/
	public function setMessageLiaisonIndirecteWithLivraison($action, $occurence)
	{
		$model_name = $this->getDomaineName();
		$message = "Oups !! $action impossible !<br />";
		foreach ($occurence as $pivot) {
			$livraison = Livraison::where('id', $pivot->livraison_id)->first();
			$message .= trans("message.$model_name.liedToLivraison", ['date' => DateFr::complete($livraison->date_livraison)]).'<br />';
		}
		return $message;
	}


	public function ListForLivraisonEdit($livraison_id){
		$items = $this->model->with(['indisponibilites' => function ($query) {
			$query->oldest('date_debut');
		}, 'livraison'])
		->where('is_actived', 1)
		->orderBy('rang')->get();

		$livraisonD = new \App\Domaines\LivraisonDomaine;
		$this->liv_concerned = $livraisonD->findFirst($livraison_id);

		$items = $items->each(function ($item) {
			if (!$item->indisponibilites->isEmpty()) {
				foreach ($item->indisponibilites as $key => $indisponibilite) {
					$item = $this->setIfIndispoForAllDates($item, $key, $indisponibilite);
					$item = $this->setIfIndispoForDateLivraison($item, $key, $indisponibilite);
				}
			}

			$item = $this->setIsLiedWithLivraison($item);
		});
		return $items;
	}


	public function setIfIndispoForDateLivraison($item, $key, $indisponibilite){
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


	private function setIsLiedWithLivraison($item){
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