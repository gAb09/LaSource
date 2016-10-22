<?php

namespace App\Domaines;

use App\Models\Livraison;

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


	public function findFirst($critere, $colonne = 'id')
	{
		return $this->model->where($colonne, $critere)->first();
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
	public function checkIfLiaisonDirecteWithLivraison($model_id, $action)
	{
		$this->model = $this->model->withTrashed()->with('livraison')->where('id', $model_id)->first();
		/* Si il existe au moins une livraison non archivée liée */
		if (!$this->model->livraison->isEmpty()) {
			$this->message = $this->setMessageLiaisonDirecteWithLivraison($action);
			return true;
		}else{
			return false;
		}
	}



	/**
	* Construction du mesage précisant la ou les liaisons directes..
	* 
	* @return string
	**/
	public function setMessageLiaisonDirecteWithLivraison($action)
	{
		$model_name = $this->getDomaineName();
		$message = "Oups !! $action impossible !<br />";
		foreach ($this->model->livraison as $livraison) {
			if(!$livraison->is_archived){
				$message .= trans("message.$model_name.liedToLivraison", ['date' => $livraison->date_livraison_enClair]).'<br />';
			}
		}
		return $message;
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
	* Construction du mesage précisant la ou les liaisons indirectes..
	* 
	* @return string
	**/
	public function setMessageLiaisonIndirecteWithLivraison($action, $occurence)
	{
		$model_name = $this->getDomaineName();
		$message = "Oups !! $action impossible !<br />";
		foreach ($occurence as $pivot) {
			$livraison = Livraison::where('id', $pivot->livraison_id)->first();
			$message .= trans("message.$model_name.liedToLivraison", ['date' => $livraison->date_livraison_enClair]).'<br />';
		}
		return $message;
	}



}