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
		$this->handleRequest($request);

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
		$this->livraison->paiementEnClair = $this->livraison->date_paiement->formatLocalized('%A %e %B %Y');
		$this->livraison->livraisonEnClair = $this->livraison->date_livraison->formatLocalized('%A %e %B %Y');

		return $this->livraison;
	}


	public function update($id, $request){

		$this->livraison = Livraison::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->livraison->save();
	}


	private function handleRequest($request){
		$this->livraison->date_cloture = $request->date_cloture;
		$this->livraison->date_paiement = $request->date_paiement;
		$this->livraison->date_livraison = $request->date_livraison;
		$this->livraison->remarques = $request->remarques;
		$this->livraison->is_actif = (isset($request->is_actif)?1:0);
		
	}


	public function livraisonSyncPaniers($livraison, $paniers = array())
	{
		// return 	dd($paniers);

		unset($paniers['_token']);
		$item = Livraison::find($livraison);
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
		$now = Carbon::now();
		$valeur = Carbon::createFromFormat('Y-m-d', $valeur);

		$enclair = $valeur->formatLocalized('%A %e %B %Y');
        // Carbon::setLocale('fr');
        $delai = $now->diffInDays($valeur, false);

        // dd("handleDate, nom : $nom - valeur : $valeur - date : $date - vue : $vue");
		$datas['date'] = $valeur;
		$datas['enclair'] = $enclair;
		$datas['delai'] = $delai;

		return $datas;
	}

	// public function handleDate($nom, $valeur)
	// {
	// 	$now = Carbon::now();
	// 	$date = Carbon::createFromFormat('Y-m-d', $valeur);

	// 	$enclair = $date->formatLocalized('%A %e %B %Y');
	// 	$delai = $date->diffInDays($now, false);
	// 	$item = new Livraison;
 //        // dd("handleDate, nom : $nom - valeur : $valeur - date : $date - vue : $vue");
	// 	switch ($nom) {
	// 		case 'date_cloture':
	// 		$item->date_cloture = $valeur;
	// 		$item->date_cloture_enclair = $enclair;
	// 		$item->date_cloture_delai = $delai;
	// 		break;
	// 		case 'date_paiement':
	// 		$item->date_paiement = $valeur;
	// 		$item->date_paiement_enclair = $enclair;
	// 		$item->date_paiement_delai = $delai;
	// 		break;
	// 		case 'date_livraison':
	// 		$item->date_livraison = $valeur;
	// 		$item->date_livraison_enclair = $enclair;
	// 		$item->date_livraison_delai = $delai;
	// 		break;
	// 	}

	// 	return $item;
	// }


}
