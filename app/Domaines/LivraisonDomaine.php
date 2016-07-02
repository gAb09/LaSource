<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Domaines\Domaine;
use Gab\Helpers\gabHelpers as Help;


class LivraisonDomaine extends Domaine
{
	protected $model;

	public function __construct(){
		$this->model = new Livraison;
	}

	public function index()
	{
		$items = $this->model->orderBy('id', 'desc')->get();
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
        $item =  $this->model;
        // $item->date_cloture = $item->date_paiement= $item->date_livraison = "À renseigner";
        $item->clotureEnClair = $item->paiementEnClair= $item->livraisonEnClair = "À renseigner";


		return $this->model;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}

	public function findFirst($colonne, $critere)
	{
		$item = $this->model->where($colonne, $critere)->first();
		$item->date_livraisonFR = Help::DatesFrlongue($item->date_livraison);
		return $item;

	}


	public function edit($id){
		$this->model = Livraison::where('id', $id)->first();
		
		$this->model->clotureEnClair = $this->model->date_cloture->formatLocalized('%A %e %B %Y');
		$this->model->paiementEnClair = $this->model->date_paiement->formatLocalized('%A %e %B %Y');
		$this->model->livraisonEnClair = $this->model->date_livraison->formatLocalized('%A %e %B %Y');

		return $this->model;
	}


	public function update($id, $request){
		$this->model = Livraison::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->date_cloture = $request->date_cloture;
		$this->model->date_paiement = $request->date_paiement;
		$this->model->date_livraison = $request->date_livraison;
		$this->model->remarques = $request->remarques;
		$this->model->is_actif = (isset($request->is_actif)?1:0);
		
	}

	private function traduitDate($item)
	{
		$item->date_paiementFR = gabHelpers::DatesFrlongue($item->date_paiement);
		$item->date_clotureFR = gabHelpers::DatesFrlongue($item->date_cloture);
		$item->date_livraisonFR = gabHelpers::DatesFrlongue($item->date_livraison);
		return $item;
	}

}
