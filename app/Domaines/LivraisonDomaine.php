<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\Domaine;
// use Gab\Helpers\gabHelpers as Help;
use Carbon\Carbon;


class LivraisonDomaine extends Domaine
{
	protected $livraison;

	public function __construct(){
		$this->livraison = new Livraison;
	}

	public function index()
	{
		$items = $this->livraison->orderBy('id', 'desc')->get();
		return $items;
	}

	public function create(){
		$item =  $this->livraison;
		$item->clotureEnClair = $item->paiementEnClair= $item->livraisonEnClair = " en création";

		return $item;
	}

	public function store($request){
		$this->handleDatas($request);

		$result = $this->livraison->save();
		if($result){
			return $this->livraison->id;
		}else{
			return $result;
		}
	}

	public function findFirst($colonne, $critere)
	{
		$item = $this->livraison->where($colonne, $critere)->first();
		return $item;

	}


	public function edit($id){
		$this->livraison = Livraison::with('Panier')->where('id', $id)->first();
		
		// $this->livraison->clotureEnClair = $this->livraison->date_cloture->formatLocalized('%A %e %B %Y');
		// $this->livraison->paiementEnClair = $this->livraison->date_paiement->formatLocalized('%A %e %B %Y');
		// $this->livraison->livraisonEnClair = $this->livraison->date_livraison->formatLocalized('%A %e %B %Y');

		return $this->livraison;
	}


	public function update($id, $request){

		$this->livraison = Livraison::where('id', $id)->first();
		$this->handleDatas($request);

		return $this->livraison->save();
	}


	private function handleDatas($request){
		$this->livraison->date_cloture = $request->date_cloture;
		$this->livraison->date_paiement = $request->date_paiement;
		$this->livraison->date_livraison = $request->date_livraison;
		$this->livraison->remarques = $request->remarques;
		$this->livraison->is_actif = (isset($request->is_actif)?1:0);
		
	}


	public function livraisonSyncPaniers($livraison_id, $paniers = array())
	{
		// return 	dd($paniers);

		unset($paniers['_token']);
		$item = Livraison::find($livraison_id);
		if(empty($paniers)){
			return $item->panier()->detach();
		}else{
			return $this->handleLivraisonSyncPaniers($item, $paniers);
		}
	}


	public function handleLivraisonSyncPaniers($item, $paniers)
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
			return $item->panier()->sync($datas);
		}
		return $item->panier()->sync($paniers['panier_id']);
	}




	public function detachPanier($livraison, $panier)
	{
		$item = Livraison::find($livraison);
		$item->panier()->detach($panier);
	}




	public function getComboDate($valeur)
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
