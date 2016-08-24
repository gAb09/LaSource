<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\Domaine;
// use Gab\Helpers\gabHelpers as Help;
use Carbon\Carbon;


class LivraisonDomaine extends Domaine
{
	protected $model;

	public function __construct(){
		$this->model = new Livraison;
	}

	public function index()
	{
		return $this->model->orderBy('id', 'desc')->get();
	}

	public function create(){
		$model =  $this->model;
		$model->clotureEnClair = $model->paiementEnClair= $model->livraisonEnClair = " en création";

		return $model;
	}

	public function store($request){
		$this->handleDatas($request);

		$result = $this->model->save();
		if($result){
			return $this->model->id;
		}else{
			return $result;
		}
	}

	public function findFirst($critere, $colonne = 'id')
	{
		return $this->model->where($colonne, $critere)->first();
	}


	public function edit($id)
	{
		return Livraison::with('Panier')->where('id', $id)->first();
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
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		
	}


	public function livraisonSyncPaniers($model_id, $paniers = array())
	{
		// return 	dd($paniers);

		unset($paniers['_token']);
		$model = Livraison::find($model_id);
		if(empty($paniers)){
			return $model->panier()->detach();
		}else{
			return $this->handleLivraisonSyncPaniers($model, $paniers);
		}
	}


	public function handleLivraisonSyncPaniers($model, $paniers)
	{

		// return dd('handleLivraisonSyncPaniers');
		// dd($paniers);
		$datas = array();
		$nombre = count($paniers['panier_id'])-1;
		// dd($nombre);
		if (array_key_exists('producteur', $paniers)) {
			foreach ($paniers['panier_id'] as $panier) {
				$datas[$panier] = [ 'producteur' => $paniers['producteur'][$panier], 'prix_livraison' => $paniers['prix_livraison'][$panier] ];
			}
			return $model->panier()->sync($datas);
		}
		return $model->panier()->sync($paniers['panier_id']);
	}




	public function detachPanier($model_id, $panier)
	{
		$model = Livraison::find($model_id);
		$model->panier()->detach($panier);
	}




	public function getComboDatesLivraison($valeur)
	{
		if ($valeur == 0) {
			$datas['date'] = '';
			$datas['enclair'] = 'À définir';
			$datas['delai'] = '– – – –';
			return $datas;
		}
		
		$now = Carbon::now();
		$valeur = Carbon::createFromFormat('Y-m-d', $valeur);

		$enclair = $valeur->formatLocalized('%A %e %B %Y');
        // Carbon::setLocale('fr');
		$delai = $now->diffInDays($valeur, false);
		$delai = $this->getDelaiExplicite($delai);

        // dd("handleDate, nom : $nom - valeur : $valeur - date : $date - vue : $vue");
		$datas['date'] = $valeur;
		$datas['enclair'] = $enclair;
		$datas['delai'] = $delai;

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
		// var_dump("delai : $delai");
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

		// dd("delai_explicite : $delai_explicite – prefix : $prefix – chiffre : $chiffre – suffix : $suffix");

		return $delai_explicite;
	}


}
