<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class CommandeDomaine extends Domaine
{

	private $montant_ligne = 0;

	public function __construct(){
		$this->model = new Commande;
	}


	/**
	 * •Executer une requete sql "à plat" avec multiples joins pour reconstituer des commandes et des lignes complètes, avec :
	 *   Commandes : ses propres données + nom client, 
	 *   Lignes : ses propres données + nom panier en clair + producteur et prix livraison associé à ce colis.
	 * • Rassembler les lignes au sein de leur commande mère 
	 *   après avoir calculé le montant de chaque ligne et le total commande.
	 * • Effectuer une pagination
	 *
	 * @return Illuminate\Pagination\Paginator
	 **/
	public function index($pages){
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->whereIn('id', [62, 63])->orderBy('id', 'DESC')->get();
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->orderBy('id', 'DESC')->paginate($pages);

		$commandes->each(function ($commande, $keys) {
			$commande->lignes->each(function ($ligne, $keys) use($commande){
				$ligne->complement = $this->doQuery($commande->livraison_id, $ligne->panier_id);
				// var_dump('commande : '.$commande->id);
				// var_dump($commande->livraison_id);
				// var_dump($ligne->panier_id);
				// var_dump($ligne->complement);
			});
		});

		// return dd('FIN');
		// return dd($commandes[0]->lignes);
		return $commandes;
	}


	private function doQuery($livraison_id, $panier_id){

		$models = \DB::table('livraison_panier')

		// Producteur
		->leftjoin('producteurs', function ($join) {
			$join->on('producteurs.id', '=', 'livraison_panier.producteur');
		})

		->where([['livraison_id', '=', $livraison_id], ['panier_id', '=', $panier_id]])
		->select(
			'livraison_panier.producteur', 'livraison_panier.prix_livraison' // Pivot livraison_panier
			, 'producteurs.exploitation as producteur' // Producteur
			)
		->get();

		return $models;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function handleCommande($raw){

		$commandeOk = new \Illuminate\Support\Collection;
		$commandeOk->idcommande = $raw->idcommande;
		$commandeOk->numero = $raw->numero;
		if (!is_null($raw->created_at)) {
		$commandeOk->datecreation = Carbon::createFromFormat('Y-m-d G:i:s', $raw->created_at)->formatLocalized('%A %e %B %Y');
		}else{
			'Pas de date de création';
		}
		$commandeOk->state = 'ToDo' ; // ToDo

		if (!is_null($raw->date_livraison)) {
			$commandeOk->date_livraison = Carbon::createFromFormat('Y-m-d G:i:s', $raw->date_livraison)->formatLocalized('%A %e %B %Y');
		}else{
			$commandeOk->date_livraison = 0;
		}

		$commandeOk->livraison_archived = $raw->livraison_archived;

		$commandeOk->client = $raw->prenom.' '.$raw->nom;

		$commandeOk->relais = $raw->relais;

		$commandeOk->modepaiement = $raw->modepaiement;

		$commandeOk->montant_total = 0;

		// return dd($raw);
		// return dd($commandeOk);
		return $commandeOk;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function handleLignes($raw){
		$ligne = new \Illuminate\Support\Collection;
		(int) $ligne->quantite = $raw->quantite;
		(int) $ligne->prix_livraison = $raw->prix_livraison;
		$ligne->montant_ligne = $ligne->quantite * $ligne->prix_livraison;
		$ligne->panier = $raw->panier;
		$ligne->panier_id = $raw->panier_id;
		$ligne->producteur = $raw->producteur;
		$this->montant_ligne = $ligne->montant_ligne;
		return $ligne;
	}

}