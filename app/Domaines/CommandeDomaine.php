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
	public function index($pages = 5){
		$raws = $this->doQuery();

		$commandes = new \Illuminate\Support\Collection;
		$id_en_cours = 0;  // initialisation de la boucle

		foreach ($raws as $raw) {
			if ($id_en_cours != $raw->idcommande) {
				$commandes->push($this->handleCommande($raw));
				$commandes->last()->lignes = collect();
				$commandes->last()->lignes->push($this->handleLignes($raw));
				$commandes->last()->montant_total += $this->montant_ligne;
				$id_en_cours = $raw->idcommande;
			}else{
				$commandes->last()->lignes->push($this->handleLignes($raw));
				$commandes->last()->montant_total += $this->montant_ligne;
				$id_en_cours = $raw->idcommande;
			}

		}

		// return dd($paginator);
		return $commandes;
	}


	private function doQuery(){

		$models = \DB::table('commandes')

		// lignes
		->join('lignes', function ($join) {
			$join->on('lignes.commande_id', '=', 'commandes.id');
		})

		// Panier
		->leftjoin('paniers', function ($join) {
			$join->on('lignes.panier_id', '=', 'paniers.id');
		})

		// Livraison
		->leftjoin('livraisons', function ($join) {
			$join->on('commandes.livraison_id', '=', 'livraisons.id');
		})

		// Client
		->leftjoin('clients', function ($join) {
			$join->on('clients.id', '=', 'commandes.client_id');
		})

		// Relais
		->leftjoin('relais', function ($join) {
			$join->on('commandes.relais_id', '=', 'relais.id');
		})

		// Mode de paiement
		->leftjoin('modepaiements', function ($join) {
			$join->on('commandes.modepaiement_id', '=', 'modepaiements.id');
		})

		// Pivot livraison_panier
		->leftjoin('livraison_panier', function ($join) {
			$join->on('commandes.livraison_id', '=', 'livraison_panier.livraison_id');
		})

		// Producteur
		->leftjoin('producteurs', function ($join) {
			$join->on('producteurs.id', '=', 'livraison_panier.producteur');
		})

		// ->whereIn('commande_id',[62, 63, 65])
		->select('commandes.id as idcommande', 'commandes.numero as numero', 'commandes.created_at' // Commande
			, 'livraisons.is_archived as livraison_archived', 'livraisons.date_livraison as date_livraison' // Livraison
			, 'clients.prenom', 'clients.nom' // Client
			, 'lignes.id', 'lignes.panier_id', 'lignes.quantite' // Lignes
			, 'paniers.nom as panier' // Panier
			, 'relais.nom as relais' // Relais
			, 'modepaiements.nom as modepaiement' // Mode de paiement
			, 'livraison_panier.producteur', 'livraison_panier.prix_livraison' // Pivot livraison_panier
			, 'producteurs.exploitation as producteur' // Producteur
			)
		// ->groupBy('lignes.panier_id')
		->orderBy('lignes.commande_id', 'DESC')
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