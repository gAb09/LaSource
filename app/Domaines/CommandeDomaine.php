<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domaines\LigneDomaine;
use App\Domaines\ModePaiementDomaine;
use App\Domaines\RelaisDomaine;
use App\Models\Livraison;
use App\Models\Ligne;
use App\Models\User;

class CommandeDomaine extends Domaine
{

	private $montant_ligne = 0;

	public function __construct(){
		$this->model = new Commande;
		$this->lignesD = new LigneDomaine;
		$this->ligne = new Ligne;
		$this->modepaiementD = new ModePaiementDomaine;
		$this->relaissD = new RelaisDomaine;
	}


	/**
	 *
	 * @param Integer : nombre de commandes par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function index($pages){
		$commandes = $this->model->with('lignes.panier', 'Livraison', 'Client', 'Relais', 'ModePaiement')->orderBy('id', 'DESC')->paginate($pages);

		$commandes->each(function ($commande, $keys) {
			$commande = $this->getAllLignes($commande);
		});

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


	/**
	 * undocumented function
	 *
	 * @param integer : commande_id
	 *
	 * @return void
	 **/
	function edit($commande_id)
	{

		// $model = User::with('client.commandes.livraison')->find($auth_user->id);
		$model = User::with('client.commandes.livraison')->find(300);

		$commandeBrute = $this->model->with('livraison.panier', 'lignes')->findOrFail($commande_id);
		$commande = $this->getAllLignes($commandeBrute);

		/* Pour chaque panier de cette livraison, connaître les quantités commandées par l'user current et les fournir à la vue */
		$livraison = $commande->livraison;
		$livraison->panier->each(function($panier) use($livraison, $commande){
			$commande->lignes->each(function($ligne) use ($livraison, $commande, $panier){
				if ($panier->id == $ligne->panier_id) {
					$panier->quantite = $ligne->quantite;
				}
			});
		});

		/* Connaître le relais choisi par l'user current pour cette livraison et le fournir à la vue */
		$relaiss = $this->relaissD->allActived('id');
		$relaiss->each(function($item) use($commande){
			if ($item->id == $commande->relais_id) {
				$item->checked = 'checked';
			}else{
				$item->checked = '';
			}
		});

		/* Connaître le mode de paiement choisi par l'user current pour cette livraison et le fournir à la vue */
		$modespaiement = $this->modepaiementD->allActived('id');
		$modespaiement->each(function($item) use($commande){
			if ($item->id == $commande->modepaiement_id) {
				$item->checked = 'checked';
			}else{
				$item->checked = '';
			}
		});

		$datas['commande'] = $commande;
		$datas['livraison'] = $livraison;
		$datas['modespaiement'] = $modespaiement;
		$datas['relaiss'] = $relaiss;
		$datas['model'] = $model;

        // return dd($commande);
		return $datas;
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
        	if (isset($value['paniers'])) { // Forcément, on ne traite pas une commande sans panier commandé…
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
	 * • Effectuer une requete d'une commande avec ses relations, y compris les lignes avec leur relation panier pour le nom en clair de celui-ci.
	 * • Pour chaque lignes en effectuer le complément (obtention du producteur associé au panier et son prix_livraison.
	 * + pagination
	 *
	 * @param App\Models\Commande
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	function getAllLignes($commande)
	{
		$commande->montant_total = 0;

		$commande->lignes->each(function ($ligne, $keys) use($commande){
			$complement = $this->lignesD->completeLignes($commande->livraison_id, $ligne->panier_id);
			$ligne->prix_livraison = $complement->prix_livraison;
			$ligne->montant_ligne = $ligne->prix_livraison*$ligne->quantite;
			$ligne->producteur = $complement->producteur;
			$ligne->panier_nom = $complement->panier_nom;
			$ligne->panier_type = $complement->panier_type;
			$commande->montant_total += $ligne->montant_ligne;
		});
		return $commande;

	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function getRapportDashboard($livraison_id)
	{
		$commandes = $this->model->where('livraison_id', $livraison_id)->get();
		$commandes->each(function($commande){
			$commande = $this->getAllLignes($commande);
			$commande->load('client');
		});
		// return dd($commandes);
		return $commandes;
	}



	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function toggleBooleanProperty($property, $id)
	{
		try{
			$model = $this->model->with('livraison')->findOrFail($id);

			if($this->isToggleAuthorized($model, $property)){

				$reponse['status'] = true;

				(bool) $valeur = !($model->{$property});
				$model->{$property} = (int)$valeur;
				$model->save();

				$etat = $this->handleState($model);
				if ($etat == 'C_NONPAID') {
					$button = <<<EOT
<a class="close" title="Envoyer mail de relance au client $model->client_id" 
onClick="javascript:alert('Envoyer mail de relance au client $model->client_id');">
<i class="btn_close fa fa-btn fa-mail-forward" style="font-size:0.6em"></i>
</a>
EOT;

					$reponse['etat'] = trans('statuts.'.$etat).$button;
				}else{
					$reponse['etat'] = trans('statuts.'.$etat);
				}

			}else{
				$reponse['status'] = false;
				$reponse['message'] = '<div class="alert alert-danger">'.$this->message.'</div>';
			}
			return $reponse;

		}catch(\exception $e){
			$reponse['status'] = false;

			/* $this->alertOuaibMaistre($e); */
			$message = trans('message.bug.transmis');

			$reponse['message'] = '<div class="alert alert-danger">'.trans('message.booleen.Failed').$message.'</div>';

			return $reponse;
		}
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isToggleAuthorized($model, $property)
	{
		$this->message = "un beau message";
		return true;
	}



    /**
     * Non implémentée.
     * Prévoit la possibilté de fixer des conditions avant qu'une livraison créée puisse être ouverte,
     * (par exemple qu'un nombre minimum de commandes soit atteint).
     *
     * @var array
     */
    public function checkIfOkForOuverture()
    {
    	if (1 == 1) {
    		return true;
    	}
    }


    public function handleState($model)
    {
    	$nouvel_etat = "C_CREATED";

    	if ($this->checkIfOkForOuverture()) {
    		$nouvel_etat = "C_REGISTERED";
    	}

    	/* date de clôture passée */
    	if ($model->livraison->date_cloture->diffInDays(Carbon::now(), false) > 0) {
    		$nouvel_etat = "C_CLOTURED";
    	}

    	/* date de paiement passée */
    	if ($model->livraison->date_paiement->diffInDays(Carbon::now(), false) > 0) {
    		if ($model->is_paid) {
    			$nouvel_etat = 'C_PAID';
    		}else{
    			$nouvel_etat = 'C_NONPAID';
    		}
    	}

    	/* date de livraison passée */
    	if ($model->livraison->date_livraison->diffInDays(Carbon::now(), false) > 0) {
    		if ($model->is_retired and $model->is_paid) {
    			$nouvel_etat = 'C_ARCHIVABLE';
    		}
    		if (!$model->is_retired and $model->is_paid) {
    			$nouvel_etat = 'C_OUBLIED';
    		}
    		if ($model->is_retired and !$model->is_paid) {
    			$nouvel_etat = 'C_NONPAID';
    		}
    		if (!$model->is_retired and !$model->is_paid) {
    			$nouvel_etat = 'C_SUSPECTED';
    		}

    	}

    	if ($model->statut == 'C_ARCHIVED') {
    		$nouvel_etat = "C_ARCHIVED";
    	}

    	return $nouvel_etat;

    }

}