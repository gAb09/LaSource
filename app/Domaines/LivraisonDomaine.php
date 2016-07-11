<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\Domaine;
use Gab\Helpers\gabHelpers as Help;


class LivraisonDomaine extends Domaine
{
	protected $livraison;

	public function __construct(){
		$this->livraison = new Livraison;
	}

	public function index()
	{
		$items = $this->livraison->orderBy('id', 'desc')->get();
		$items->each(function ($item, $key) {
			if($key = 'date_paiement'){
				$item->date_paiementFR = Help::DatesFrlongue($item->date_paiement);
			}
			if($key = 'date_cloture'){
				$item->date_clotureFR = Help::DatesFrlongue($item->date_cloture);
			}
			if($key = 'date_livraison'){
				$item->date_livraisonFR = Help::DatesFrlongue($item->date_livraison);
			}
		});
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
		$item->date_livraisonFR = Help::DatesFrlongue($item->date_livraison);
		return $item;

	}


	public function edit($id){
		$this->livraison = Livraison::with('Panier')->where('id', $id)->first();
		
		$this->livraison->clotureEnClair = $this->livraison->date_cloture->formatLocalized('%A %e %B %Y');
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
			$item->panier()->detach();
		}else{
			$this->handleLivraisonSyncPaniers($item, $paniers);
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
			for ($i=0; $i <= $nombre; $i++) { 
				$datas[ $paniers['panier_id'][$i] ]['producteur'] = $paniers['producteur'][$i];
				$datas[ $paniers['panier_id'][$i] ]['prix_livraison'] = $paniers['prix_livraison'][$i];
			}
			$item->panier()->sync($datas);
		}

		// dd($datas);
		$item->panier()->sync($paniers['panier_id']);
	}




	public function detachPanier($livraison, $panier)
	{
		$item = Livraison::find($livraison);
		$item->panier()->detach($panier);
	}


}
