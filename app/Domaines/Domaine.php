<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Models\Commande;
use Gab\Helpers\DateFr;
use Carbon\Carbon;

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
    * La réponse fournie sur une requête ajax.
    * Dispose d'un accesseur à l'attention des controleurs
    **/
    protected $reponse = array();


    /**
    * Les états qui nécessitent d'être actualisés quotidiennement pour une livraison.
    **/
    protected $livraison_morte = ['L_ARCHIVED', 'L_ARCHIVABLE', 'L_ANNULED'];


    /**
    * Les états qui nécessitent d'être actualisés quotidiennement pour une commande.
    **/
    protected $commande_morte = ['C_ARCHIVED', 'C_ARCHIVABLE', 'C_ANNULED'];



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
    * Accesseur réponse.
    * 
    * @return array
    **/
    public function getReponse(){
    	return $this->reponse;
    }



    /**
    * Obtention du nom de la classe courante en minuscules.
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


	/**
	* Si l'update comporte une désactivation du model (!isset($request->is_actived),
	* il faut d'abord vérifier que ce model n'est impliqué dans aucune livraison créée, ouverte ou clôturée.
	* Si le model était déjà désactivé, il n'avait pas pu être associé à une livraison,
	* donc le résultat de 'hasLiaisonDirecteWithLivraison' sera forcément false, donc la vérification sera traversée sans effet.
	* Sinon le résultat de la vérification dépendra de la valeur de 'hasLiaisonDirecteWithLivraison'
	* et soit renverra directement false au contrôleur soit sera traversée.
	* La relation est dite directe si l'entité est liée à l'entité livraison via une table pivot.
	* La relation est dite indirecte si l'entité est liée à l'entité livraison via une foreign key dans la table pivot 'livraison/panier'.
	* 
	* @return boolean : true si la mise à jour a été faite | false dans les autres cas.
	**/
	public function update($id, $request){

		$this->model = $this->model->withTrashed()->where('id', $id)->first();

		$this->handleRequest($request);
		return $this->model->save();
	}

	/**
	 * Selon le modèle concerné par une supression ou une désactivation,
	 * renvoyer le nom de la méthode à utiliser pour la détection
	 * de liaisons éventuelles avec une ou plusieurs livraisons.
	 *
	 * @return string
	 **/
	public function getVerificationType(){
		if($this->getDomaineName() == 'producteur'){
			return 'hasLiaisonIndirecteWithLivraison';
		}else{
			return 'hasLiaisonDirecteWithLivraison';
		}
	}


	public function destroy($id)
	{
		$this->model = $this->model->where('id', $id)->first();
		return $this->model->delete();
	}


	/**
	* Il faut d'abord déterminer si le model courant est en relation avec l'entité livraison de façon directe ou indirecte.
	* La relation est dite directe si le model courant est lié via une table pivot.
	* La relation est dite indirecte si le model courant est lié via une foreign key dans la table pivot 'livraison/panier'.
	* Il faut ensuite déterminer si le model courant est impliqué ou non avec une livraison créée, ouverte ou clôturée.
	* 
	* @return boolean : true si la suppresion a été faite | false dans les autres cas.
	**/
	public function destroyAfterVerif($id)
	{
		$this->model = $this->model->withTrashed()->where('id', $id)->first();

		/* Vérification directe ou indirecte ? */
		$relation_type = $this->getVerificationType();

		/* Suppression possible ? */
		if ($this->{$relation_type}('Suppression')) {
			return false;
		}

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
	public function hasLiaisonDirecteWithLivraison($action)
	{
		$this->model->load(['livraison' => function ($query) {
			$query->whereNotIn('statut', $this->livraison_morte);
		}])
		;
																								// return dd($this->model->livraison);
		/* Si il existe au moins une livraison concernée */
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
			$message .= trans("message.$model_name.liedToLivraison", ['date' => DateFr::complete($livraison->date_livraison)]).'<br />';
		}
		$this->message = $message;
	}



	/**
	* Contrôle si le modèle est impliqué dans une livraison (contenu dans le pivot livraison/panier)
	* 
	* @return false|string
	**/
	public function hasLiaisonIndirecteWithLivraison($action)
	{
		$model_name = $this->getDomaineName();            
		$occurences = \DB::table('livraison_panier')
		->rightjoin('livraisons', function ($join) {
			$join->on('livraisons.id', '=', 'livraison_panier.livraison_id')
			->whereNotIn('statut', $this->livraison_morte);
		})
		->where($model_name, $this->model->id)
		->select(
			'livraison_panier.*' // Pivot livraison_panier
			, 'livraisons.*' // Livraison
			);

		$occurences = $occurences->get();                // return dd($occurences);   
														 // return dd(!empty($occurences));

		if (!empty($occurences)) {
			// return dd('occurences not empty');
			$this->setMessageLiaisonIndirecteWithLivraison($action, $occurences);
			// return dd($this->message);
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
	public function setMessageLiaisonIndirecteWithLivraison($action, $occurences)
	{
		// return dd($occurences);
		$model_name = $this->getDomaineName();
		$message = "Oups !! $action impossible !<br />";
		foreach ($occurences as $occurence) {
			$date = Carbon::createFromFormat('Y-m-d H:i:s', $occurence->date_livraison);
			$message .= trans("message.$model_name.liedToLivraison", ['date' => DateFr::complete($date)]).'<br />';
		}
		$this->message = $message;
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

	public function restore($id){
		$this->model = $this->model->withTrashed()->findOrFail($id);
		return $this->model->restore();
	}


}