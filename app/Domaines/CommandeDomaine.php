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
	use EtatsCommandeDomaineTrait;

	private $montant_ligne = 0;

	public function __construct(){
		$this->model = new Commande;
		$this->lignesD = new LigneDomaine;
		$this->ligne = new Ligne;
		$this->modepaiementD = new ModePaiementDomaine;
		$this->relaissD = new RelaisDomaine;
	}


	/**
	 * Lister toutes les commandes existantes quel que soit leur état.
	 *
	 * @param integer $pages : nombre de commandes par page.
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


	/**
	 * Persister une(des) nouvelle(s) commande(s)
	 * • On commence par recomposer les commandes à partir de la requête (recomposeRequest)
	 * • On initialise une transaction, puis on traite la validation et la persistance des commandes.
	 * • On catch les exceptions qui sont alors repassée au contrôleur.
	 *
	 * @param Illuminate\Http\Request $request 
	 *
	 * @return void $result : (int) 0 si aucune quantité saisie) | (int) nombre de commandes traitées) | Exception
	 **/
	public function store($request){
		try {
			$request = $request->except('_token');
			$commandes = $this->recomposeRequest($request);
			\DB::beginTransaction();
			$result = $this->validateAndStore($commandes);
		}
		catch(\exception $e){
			\DB::rollBack();
			return $e;
		}

		\DB::commit();
		return $result;
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
		// 'paiement_initial' => $livraison->paiement_initial, 
		// 'relais_initial' => $livraison->relais_initial, 

		/* Connaître le relais choisi par l'user current pour cette livraison et le fournir à la vue */
		$relaiss = $this->relaissD->allActived('id');
		$relaiss->each(function($item) use($commande, $livraison){
			if ($item->id == $commande->relais_id) {
				$livraison->relais_initial = $item->id;
			}
		});

		/* Connaître le mode de paiement choisi par l'user current pour cette livraison et le fournir à la vue */
		$modespaiement = $this->modepaiementD->allActived('id');
		$modespaiement->each(function($item) use($commande, $livraison){
			if ($item->id == $commande->modepaiement_id) {
				$livraison->paiement_initial = $item->id;
			}
		});

		$datas['commande'] = $commande;
		$datas['livraison'] = $livraison;
		$datas['modespaiement'] = $modespaiement;
		$datas['relaiss'] = $relaiss;

        // return dd($commande);
		return $datas;
	}


	/**
	 * Persister les modifications sur une commande
	 * • On commence par recomposer la commande à partir de la requête (recomposeRequest)
	 * • On recherche la commande enregistrée que l'on compare au datas proposées pour déceler une absence de changement,
	 *   si c'est le ce cas on revient à la page d'origine.
	 * • Sinon on initialise une transaction, puis on traite la validation et la persistance des commandes.
	 * • Si on a catché des exceptions elles sont repassées au contrôleur.
	 *
	 * @param Illuminate\Http\Request $request 
	 *
	 * @return void $result : (int) 0 si aucune modification) | (int) nombre de commandes traitées) | Exception
	 **/
	public function update($id, $request){
		try {
			$datas = $request->except('_token', '_method');
			$commandes = $this->recomposeRequest($datas);
			\DB::beginTransaction();
			$result = $this->validateAndUpdate($commandes, $id);
		}
		catch(\exception $e){
			\DB::rollBack();
			return $e;
		}

		\DB::commit();
		return $result;
	}


	/**
	 * Décomposer/recomposer les éléments de la requête pour préparer le traitement de la (des) commande(s).
	 *
	 * @param Illuminate\Http\Request $request 
	 *
	 * @return array : commande recomposée
	 **/
	private function recomposeRequest($datas)
	{
		return dd($datas);
		$commandes = [];
		$this->cumul_qte = 0;
		foreach ($datas as $key => $value) {
			if ($value !== "") {
				$value = (int) $value;
				$key_parts = explode("_", $key);
				$livraison_id = $key_parts[0];
				if ($key_parts[1] == 'qte') { 		
					$commandes[$livraison_id]['paniers'][$key_parts[2]] = $value; /* $key_parts[1] = "qte" - $key_parts[2] = "panier_id"  */
					$this->cumul_qte += $value;
				}else{  															
					$commandes[$livraison_id][$key_parts[1]] = $value; /* $key_parts[1] = "paiement" || "relais" */
				}
			}
		}
		return $commandes;
	}


	/**
     * Procéder aux validations, puis enregistrer commandes + lignes.
     *
	 * @param array $commandes
	 *
	 * @return int $result : 0 si aucune quantité saisie) | nombre de commandes traitées)
	 **/
	private function validateAndStore($commandes)
	{
		$result = (int) 0;
		foreach($commandes as $livraison_id => $values){
			if ($this->getCumulQte() !== 0) {
				$this->validate($livraison_id, $values);

				$this->model = $this->model->create();

				$this->model->livraison_id =  $livraison_id;
				$this->model->client_id = \Auth::user()->id;
				$this->model->numero = \date('y')."-C".\Auth::user()->id."-".$this->model->id;
				$this->model->relais_id = $values['relais'];
				$this->model->modepaiement_id = $values['paiement'];
				$this->model->statut = $this->getEtat($this->model);;

				$this->model->save();
				$result++;

				foreach ($values['paniers'] as $id => $qte) {
					$ligne = new ligne(['commande_id' => $this->model->id, 'panier_id' => $id, 'quantite' => $qte]); 
					$ligne->save(); 
				}
			}
		}
		return $result;
	}


	/**
     * Procéder aux validations, puis modifier commandes + lignes.
     *
	 * @param array $commandes
	 *
	 * @return int $result : 0 si aucune quantité saisie) | nombre de commandes traitées)
	 **/
	private function validateAndUpdate($commandes, $id)
	{
		$result = (int) 0;

		$this->model = $this->model->where('id', $id)->first();
		// dd($this->model);

		// var_dump($commandes);
		foreach($commandes as $livraison_id => $values){
			if ($this->getCumulQte() !== 0) {
				$this->validate($livraison_id, $values);


				$this->model->relais_id = $values['relais'];
				$this->model->modepaiement_id = $values['paiement'];
				$this->model->statut = $this->getEtat($this->model);;

				// $this->model->save();
				$result++;

				foreach ($values['paniers'] as $id => $qte) {
					$ligne = $this->ligne->where('panier_id', $id)->where('commande_id', $this->model->id)->first();
					var_dump($id);
					var_dump($this->model->id);
					var_dump($qte);
					// return dd($ligne);
					$ligne->quantite = $qte;

					$ligne->save(); 
				}
				// dd('fin');
			}
		}
		// return dd($result);
		return $result;
	}


    /**
     * On ne fait le traitement que si au moins une quantité est non nulle
     *
     * @return void
     * @author 
     **/
    private function getCumulQte()
    {
    	return $this->cumul_qte;
    	
    }





    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    private function validate($livraison_id, $values)
    {
    	if(!isset($values['paiement'])){
    		$livraison_date = $this->getLivraisonDateForException($livraison_id);
    		$message = trans('message.commande.paiementRequired', ['date' => $livraison_date]);
    		throw new \Exception($message, 1);
    	}

    	if(!isset($values['relais'])){
    		$livraison_date = $this->getLivraisonDateForException($livraison_id);
    		$message = trans('message.commande.relaisRequired', ['date' => $livraison_date]);
    		throw new \Exception($message, 1);
    	}

    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    private function getLivraisonDateForException($livraison_id)
    {
    	$date = Livraison::findOrFail($livraison_id)->date_livraison;
    	return  Carbon::createFromFormat('Y-m-d H:i:s', $date)->formatLocalized('%A %e %B %Y');
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

			if($this->isChangeAuthorized($model, $property)){

				$reponse['status'] = true;

				(bool) $valeur = !($model->{$property});
				$model->{$property} = (int)$valeur;
				$model->save();

				$etat = $this->getEtat($model);
				$reponse['etat'] = trans('statuts.'.$etat);
				if ($etat == 'C_NONPAID') {
					$button = <<<EOT
					<a class="close" title="Envoyer mail de relance au client $model->client_id" 
					onClick="javascript:alert('Envoyer mail de relance au client $model->client_id');">
					<i class="btn_close fa fa-btn fa-mail-forward" style="font-size:0.6em"></i>
					</a>
EOT;
					$reponse['etat'] .= $button;
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
	private function transcode_modepaiement($modepaiement)
	{
		if ($modepaiement == 'chèque') {
			return ModePaiement::where('nom', 'Chèque')->first()->id;
		}elseif ($modepaiement == 'virement') {
			return ModePaiement::where('nom', 'Virement')->first()->id;
		}
		return ModePaiement::where('nom', 'Problème')->first()->id;
	}
}