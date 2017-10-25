<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domaines\LigneDomaine;
use App\Models\Ligne;

class CommandeDomaine extends Domaine
{

	private $montant_ligne = 0;

	public function __construct(){
		$this->model = new Commande;
		$this->lignesD = new LigneDomaine;
		$this->ligne = new Ligne;
	}


	/**
	 *
	 * @param Integer : nombre de commandes par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function index($pages){
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->orderBy('id', 'DESC')->paginate($pages);

		$commandes = $this->getAllLignes($commandes);

		return $commandes;

	}


	public function store($request){

		try {
		$commandes = $this->handleRequest($request);
		\DB::beginTransaction();
		$count = $this->handleCommandes($commandes);
		}
		catch(\exception $e){
			\DB::rollBack();
			return $e;
		}

		\DB::commit();
		return $count;
	}



	private function transcode_modepaiement($modepaiement)
	{
		if ($modepaiement == 'chèque') {
			return ModePaiement::where('nom', 'Chèque')->first()->id;
		}elseif ($modepaiement == 'virement') {
			return ModePaiement::where('nom', 'Virement')->first()->id;
		}
		return ModePaiement::where('nom', 'Problème')->first()->id;
	}


	/**
	 * Décompose/recompose les éléments de la requête pour traiter les valeurs de la (des) commande(s).
	 *
	 * @return array : recomposition des commandes
	 **/
	private function handleRequest($request)
	{
		foreach ($request->except('_token') as $key => $value) {
			if (!($value == 0 or $value == "")) {
				$key_parts = explode("_", $key);
				if (count($key_parts) == 2) {
					$commandes[$key_parts[0]][$key_parts[1]] = $value;
				}else{
					$commandes[$key_parts[0]]['paniers'][$key_parts[2]] = $value;
				}
			}
		}
		return $commandes;
	}



	/**
	 * Enregistre les commandes valides ainsi que les lignes associées.
	 *
	 **/
	private function handleCommandes($commandes)
	{
		$count = (int) 0;
		foreach($commandes as $key => $value){
        	if (isset($value['paniers'])) { // on ne traite forcément pas une commande sans panier commandé…
        		$this->model = $this->model->create();
        		// return dd($this->model);
        		// $this->model->id = \DB::table('commandes')->max('id')+1;
        		$this->model->livraison_id =  $key;
        		$this->model->client_id = \Auth::user()->id;
        		$this->model->numero = \date('y')."-C".\Auth::user()->id."-".$this->model->id;
        		$this->model->relais_id = $value['relais'];
        		$this->model->modepaiement_id = $value['paiement'];

        		$this->model->save();
        		$count++;

        		foreach ($value['paniers'] as $id => $qte) {
        			$ligne = new ligne(['commande_id' => $this->model->id, 'panier_id' => $id, 'quantite' => $qte]); 
        			$ligne->save(); 
        		}
        	}
        }
        return $count;
    }


	/**
	 * • Effectuer une requete des commandes avec ses relations, y compris les lignes avec leur relation panier pour le nom en clair de celui-ci.
	 * • Pour chaque lignes en effectuer le complément (obtention du producteur associé au panier et son prix_livraison.
	 * + pagination
	 *
	 * @param Integer : nombre de commandes par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	function getAllLignes($commandes)
	{
		$commandes->each(function ($commande, $keys) {
			$commande->montant_total = 0;

			$commande->lignes->each(function ($ligne, $keys) use($commande){
				$complement = $this->lignesD->completeLignes($commande->livraison_id, $ligne->panier_id);
				$ligne->prix_livraison = $complement->prix_livraison;
				$ligne->montant_ligne = $ligne->prix_livraison*$ligne->quantite;
				$ligne->producteur = $complement->producteur;
				$commande->montant_total += $ligne->montant_ligne;
			});
			// return dd($commande);
			return $commande;
		});

		// return dd($commandes);
		return $commandes;

	}


}