<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\RelaisDomaine;
use App\Domaines\ModePaiementDomaine;
use App\Domaines\Domaine;
use Carbon\Carbon;


class LivraisonDomaine extends Domaine
{
	public function __construct(){
		$this->model = new Livraison;
	}


	public function index($nbre_pages = 8)
	{
		return $this->model->orderBy('id', 'desc')->paginate($nbre_pages);
	}


	public function create(){
		$model =  $this->model;
		$model->clotureEnClair = $model->paiementEnClair= $model->livraisonEnClair = " en création";

		return $model;
	}


	public function store($request){
		$this->handleDatas($request);

		if($this->model->save()){
			$modepaiement = new ModePaiementDomaine;
			$relais = new RelaisDomaine;

			$modepaiements = $modepaiement->allActivedIdForSyncLivraison();
			$relaiss = $relais->allActivedIdForSyncLivraison();

			$this->model->modepaiements()->sync($modepaiements);
			$this->model->relais()->sync($relaiss);

			return $this->model->id;
		}else{
			return false;
		}
	}


	public function edit($id)
	{
		$livraison = Livraison::with('Panier')->findOrFail($id);
		foreach ($livraison->Panier as $panier) {
			if (\Session::get('new_attached')) {
				// var_dump($panier->id);
				if (in_array($panier->id, \Session::get('new_attached'))) {
					// var_dump('in_array');
					$panier->changed = "changed";
					// var_dump($panier);
				}
			}

		}
		return $livraison;
		// return dd(\Session::get('new_attached'));
	}


	public function update($id, $request){

		$this->model = Livraison::where('id', $id)->first();
		$this->handleDatas($request);

		return $this->model->save();
	}


	private function handleDatas($request){
		$this->model->date_cloture = $request->date_cloture;
		$this->model->date_paiement = $request->date_paiement;
		$this->model->date_livraison = $request->date_livraison;
		$this->model->remarques = $request->remarques;
        $this->model->is_actived = (isset($request->is_actived)?1:0);
        $this->model->statut = $request->statut;
		
	}


    /**
    * Synchronisation avec les paniers (avec ou sans les données pivot : producteur et prix).
    *
    * @param integer $model_id
    * @param array[integer, integer] $paniers
    *
    * @return ?????? | Array
    **/
    public function SyncPaniers($model_id, $paniers = array())
    {
    	unset($paniers['_token']);

    	$this->model = $this->model->find($model_id);

    	if(empty($paniers)){
    		$result = $this->model->panier()->detach();
    	}else{
    		$result = $this->prepareSyncPaniers($paniers);
    		\Session::flash('new_attached', $result['attached']);
    	}
    	return $result;
    }


    /**
    * Adaptation des données de la vue pour la synchronisation, le cas échéant incluant les données de la table pivot.
    *
    * La vue d'origine peut être :
    * – la vue modale de la liste des paniers, $paniers ne comporte alors que les panier_id
    * – la vue édition d'une livraison, $paniers comporte alors panier_id, producteur, prix_livraison
    *
    * @param integer $model_id
    * @param array[integer, integer] $paniers
    *
    * @return Array
    **/
    public function prepareSyncPaniers($paniers)
    {
    	$datas = array();
    	if (array_key_exists('producteur', $paniers)) {

    		foreach ($paniers['panier_id'] as $panier) {
    			$datas[$panier] = [ 'producteur' => $paniers['producteur'][$panier], 'prix_livraison' => $paniers['prix_livraison'][$panier] ];
    		}
    		return $this->model->panier()->sync($datas);
    	}

    	$result = $this->model->panier()->sync($paniers['panier_id']);
    	return $result;
    }



    /**
    * Détachement d’un panier depuis la vue édition d’une livraison.
    *
    * @param integer $model_id
    * @param integer $panier
    *
    * @return Redirection
    **/
    public function detachPanier($model_id, $panier)
    {
    	$model = Livraison::find($model_id);
    	$model->panier()->detach($panier);
    }



    /**
    * Synchronisation des relais.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncRelaiss($model_id, $datas = array())
    {
    	unset($datas['_token']);

    	$this->model = Livraison::find($model_id);
    	if(empty($datas['is_lied'])){
    		$result = $this->model->relais()->detach();
    	}else{
    		$sync = $this->prepareSyncModel($datas);
    		$result = $this->model->relais()->sync($sync);
    	}
    	return $result;
    }


    /**
    * Synchronisation des modes de paiement.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncModespaiements($model_id, $datas = array())
    {
    	unset($datas['_token']);

    	$this->model = Livraison::find($model_id);
    	if(empty($datas['is_lied'])){
    		$result = $this->model->Modepaiements()->detach();
    	}else{
    		$sync = $this->prepareSyncModel($datas);
    		$result = $this->model->Modepaiements()->sync($sync);
    	}
    	return $result;
    }



    /**
    * Réagencement des données issues de la vue pour les adapter à la synchronisation.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function prepareSyncModel($datas)
    {
    	$sync = array();
    	foreach ($datas['is_lied'] as $model_id => $is_lied) {
    		if ($is_lied == 1) {
    			$sync[] = $model_id;
    		}
    	}
    	return $sync;
    }



	/**
	* Composition des données pour l'affichage des dates :
	* – $valeur = $valeur transformée en objet Carbon,
	* – $enclair = $valeur en toutes lettres,
	* – $delai = différence en jours entre $valeur et maintenant.
	*
	* @param string
	* @return array[Carbon, string, string]
	**/
	public function getComboDates($valeur)
	{
		if ($valeur == 0) {
			$datas['date'] = '';
			$datas['enclair'] = 'À définir';
			$datas['delai'] = '– – – –';
		}else{

			$valeur = Carbon::createFromFormat('Y-m-d', $valeur);

			$enclair = $valeur->formatLocalized('%A %e %B %Y');

			$now = Carbon::now();
			$delai = $now->diffInDays($valeur, false);
			$delai = $this->getDelaiExplicite($delai);

			$datas['date'] = $valeur;
			$datas['enclair'] = $enclair;
			$datas['delai'] = $delai;
		}
		return $datas;
	}


	/**
	* Obtenir un texte explicite décrivant le délai entre une date et aujourd’hui.
	* Découpage en 3 parties : prefix chiffre suffix
	* • prefix = il y a | dans
	* • chiffre = valeur absolue de $delai
	* • suffix = jour | jours
	* 
	* @param integer $delai
	* 
	* @return string
	**/
	public function getDelaiExplicite($delai)
	{
		$chiffre = abs($delai);

		if ($delai == 0) {
			$delai_explicite = 'aujourd’hui';
			return $delai_explicite;
		}

		if ($delai >= 1) {
			$prefix = 'dans ';
		}else{
			$prefix = 'il y a ';
		}

		if ($chiffre == 1) {
			$suffix = ' jour';
		}else{
			$suffix = ' jours';
		}

		$delai_explicite = $prefix.$chiffre.$suffix;

		// dd("delai_explicite : $delai_explicite – prefix : $prefix – chiffre : $chiffre – suffix : $suffix");//CTRL

		return $delai_explicite;
	}


    /**
    * Archivage d'une livraison
    *
    * @param integer  /  id de la livraison
    * 
    * @return boolean
    **/
    public function archive($id)
    {
    	$this->model = $this->model->findOrFail($id);

    	if ($this->controleAvantArchivage($this->model)) {
    		$this->model->statut = 'L_ARCHIVED';
    		return $this->model->save();
    	}

    	return true;
    }


    /**
    * Controle avant archivage d'une livraison ////////////////////// ToDo
    *
    * @param  Model  / Livraison
    * 
    * @return boolean
    **/
    public function controleAvantArchivage($model)
    {
    	$this->message = trans('message.livraison.archivagefailed');
    	return true;
    }

}
