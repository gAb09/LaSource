<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Models\Commande;
use App\Domaines\Domaine;
use App\Domaines\RelaisDomaine;
use App\Domaines\ModePaiementDomaine;
use App\Domaines\ProducteurDomaine;
use App\Domaines\CommandeDomaine;
use Carbon\Carbon;


class LivraisonDomaine extends Domaine
{

  private $livraisons_ouvertes = ['L_CREATED', 'L_OUVERTE'];
  private $livraisons_vivantes = ['L_CREATED', 'L_OUVERTE', 'L_CLOTURED', 'L_MUSTBEPAID'];


  public function __construct(){
    $this->commandeD = new CommandeDomaine;
    $this->producteurD = new ProducteurDomaine;
    $this->model = new Livraison;
  }


    /**
     * undocumented function
     *
     * @param App\Models\Livraison
     *  
     * @return 
     **/
    public function getAllLivraisonsOuvertes($user = null)
    {
      $models = $this->model->orderBy('date_livraison')->whereIn('statut', $this->livraisons_ouvertes)->get();

      if (!is_null($user)) {
        /* On retire les livraisons pour lesquelles l'user courant à déjà passé commande */
        $models = $models->reject(function ($livraison) use($user){
          return $this->rejectLivraisonNonOuverteForThisCurrentUser($livraison->id, $user->id);
        });
      }        

      /* récupération du nom du producteur via son id en pivot "livraison_panier"*/
      $models->each(function($livraison){
        $livraison = $this->getProducteurs($livraison);
      });
      return $models;
    }


    /**
     * undocumented function
     *
     * @param App\Models\Livraison
     *  
     * @return 
     **/
    public function getAllLivraisonsVivantes()
    {
      $models = $this->model->with('panier')->orderBy('date_livraison')->whereIn('statut', $this->livraisons_vivantes)->get();

      /* récupération du nom du producteur via son id en pivot "livraison_panier"*/
      $models->each(function($livraison){
        if(!$livraison->panier->isEmpty()){
          $livraison = $this->getProducteurs($livraison);
        }
      });

      return $models;
    }


    /**
     * undocumented function
     *
     * @param App\Models\Livraison
     *  
     * @return 
     **/
    private function getProducteurs($livraison)
    {
      $livraison->panier->each(function($panier){
        $panier->exploitation = $this->producteurD->findFirst($panier->pivot->producteur_id)->exploitation;
      });
      return $livraison;
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function getRapportDashboard($livraison)
    {
      $model = $this->model->with('panier', 'commandes.lignes', 'relais')->find($livraison->id);

      /* Composition des lignes pour chaque panier (eux-mêmes complétés) */
      $model = $this->composeLignesPaniersForRapportLivraison($livraison, $livraison->relais);

        // return dd($model);
      return $model;
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    private function composeLignesPaniersForRapportLivraison($livraison, $relais)
    {
      $tableau_relais = $this->composeTableauDesRelais($relais);
        $tableau_relais['total'] = 0;  // Une entré est ajoutée après composition pour stocker le total

        $livraison->panier->each(function($panier)use($livraison, $tableau_relais){
          /* récupération du nom du producteur via son id en pivot "livraison_panier"*/
          $panier->exploitation = $this->producteurD->findFirst($panier->pivot->producteur_id)->exploitation;

          $complement = \DB::table('commandes')
          ->leftjoin('lignes', function ($join) use($panier){
            $join->on('commande_id', '=', 'commandes.id')
            ->where('lignes.panier_id', '=', $panier->id); 
          })
          ->leftjoin('relais', function ($join) {
            $join->on('relais.id', '=', 'commandes.relais_id');
          })
          ->where('livraison_id', $livraison->id)
          ->get(['relais.id as relais_id', 'relais.nom as relais', 'lignes.quantite as quantite']);


            /* Si il existe au moins une commande pour cette livraison, il y a donc au moins un relais (count($tableau_relais) > 1),
            Si elle n'est pas nulle, report de la quantité et ajout au calcul du nombre total de ce panier */
            foreach($complement as $item){
              if (is_integer($item->quantite) and count($tableau_relais) > 1) {
                $tableau_relais[$item->relais_id] = $tableau_relais[$item->relais_id] + $item->quantite;
                $tableau_relais['total'] = $tableau_relais['total'] + $item->quantite;
              }
            };
            $total_ligne = $panier->pivot->prix_livraison * $tableau_relais['total'];
            $livraison->chiffre_affaire += $total_ligne; /* Calcul du chiffre affaire total de cette livraison. */
            $panier->relais = $tableau_relais;

          });
return $livraison;
}


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    private function composeTableauDesRelais($relais)
    {
      $tableau = array();
      $relais->each(function($relai) use(&$tableau){
        $tableau[$relai->id] = 0;
      });
      return $tableau;
    }



    public function index($nbre_pages = 8)
    {
      return $this->model->orderBy('id', 'desc')->paginate($nbre_pages);
    }


    public function create(){
      $model =  $this->model;
      $model->clotureEnClair = $model->paiementEnClair= $model->livraisonEnClair = " en création";

      return $model;
    }


    public function store($request){
      $this->handleDatas($request);

      if($this->model->save()){
       $modepaiement = new ModePaiementDomaine;
       $relais = new RelaisDomaine;

       $modepaiements = $modepaiement->allActivedIdForSyncLivraison();
       $relaiss = $relais->allActivedIdForSyncLivraison();

       $this->model->modepaiements()->sync($modepaiements);
       $this->model->relais()->sync($relaiss);

       return $this->model->id;
     }else{
       return false;
     }
   }


   public function edit($id)
   {
    $livraison = Livraison::with('Panier')->findOrFail($id);
    foreach ($livraison->Panier as $panier) {
     if (\Session::get('new_attached')) {
				// var_dump($panier->id);
      if (in_array($panier->id, \Session::get('new_attached'))) {
					// var_dump('in_array');
       $panier->changed = "changed";
					// var_dump($panier);
     }
   }

 }
 return $livraison;
		// return dd(\Session::get('new_attached'));
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
  $this->model->is_actived = (isset($request->is_actived)?1:0);
  $this->model->statut = $request->statut;

}


    /**
    * Synchronisation avec les paniers (avec ou sans les données pivot : producteur_id et prix).
    *
    * @param integer $model_id
    * @param array[integer, integer] $paniers
    *
    * @return ?????? | Array
    **/
    public function SyncPaniers($model_id, $paniers = array())
    {
    	unset($paniers['_token']);

    	$this->model = $this->model->find($model_id);

    	if(empty($paniers)){
    		$result = $this->model->panier()->detach();
    	}else{
    		$result = $this->prepareSyncPaniers($paniers);
    		\Session::flash('new_attached', $result['attached']);
    	}
    	return $result;
    }


    /**
    * Adaptation des données de la vue pour la synchronisation, le cas échéant incluant les données de la table pivot.
    *
    * La vue d'origine peut être :
    * – la vue modale de la liste des paniers, $paniers ne comporte alors que les panier_id
    * – la vue édition d'une livraison, $paniers comporte alors panier_id, producteur_id, prix_livraison
    *
    * @param integer $model_id
    * @param array[integer, integer] $paniers
    *
    * @return Array
    **/
    public function prepareSyncPaniers($paniers)
    {
    	$datas = array();
    	if (array_key_exists('producteur_id', $paniers)) {

    		foreach ($paniers['panier_id'] as $panier) {
    			$datas[$panier] = [ 'producteur_id' => $paniers['producteur_id'][$panier], 'prix_livraison' => $paniers['prix_livraison'][$panier] ];
    		}
    		return $this->model->panier()->sync($datas);
    	}

    	$result = $this->model->panier()->sync($paniers['panier_id']);
    	return $result;
    }



    /**
    * Détachement d’un panier depuis la vue édition d’une livraison.
    *
    * @param integer $model_id
    * @param integer $panier
    *
    * @return Redirection
    **/
    public function detachPanier($model_id, $panier)
    {
    	$model = Livraison::find($model_id);
    	$model->panier()->detach($panier);
    }



    /**
    * Synchronisation des relais.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncRelaiss($model_id, $datas = array())
    {
    	unset($datas['_token']);

    	$this->model = Livraison::find($model_id);
    	if(empty($datas['is_lied'])){
    		$result = $this->model->relais()->detach();
    	}else{
    		$sync = $this->prepareSyncModel($datas);
    		$result = $this->model->relais()->sync($sync);
    	}
    	return $result;
    }


    /**
    * Synchronisation des modes de paiement.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncModespaiements($model_id, $datas = array())
    {
    	unset($datas['_token']);

    	$this->model = Livraison::find($model_id);
    	if(empty($datas['is_lied'])){
    		$result = $this->model->Modepaiements()->detach();
    	}else{
    		$sync = $this->prepareSyncModel($datas);
    		$result = $this->model->Modepaiements()->sync($sync);
    	}
    	return $result;
    }



    /**
    * Réagencement des données issues de la vue pour les adapter à la synchronisation.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function prepareSyncModel($datas)
    {
    	$sync = array();
    	foreach ($datas['is_lied'] as $model_id => $is_lied) {
    		if ($is_lied == 1) {
    			$sync[] = $model_id;
    		}
    	}
    	return $sync;
    }



	/**
	* Composition des données pour l'affichage des dates :
	* – $valeur = $valeur transformée en objet Carbon,
	* – $enclair = $valeur en toutes lettres,
	* – $delai = différence en jours entre $valeur et maintenant.
	*
	* @param string
	* @return array[Carbon, string, string]
	**/
	public function getComboDates($valeur)
	{
		if ($valeur == 0) {
			$datas['date'] = '';
			$datas['enclair'] = 'À définir';
			$datas['delai'] = '– – – –';
		}else{

			$valeur = Carbon::createFromFormat('Y-m-d', $valeur);

			$enclair = $valeur->formatLocalized('%A %e %B %Y');

			$now = Carbon::now();
			$delai = $now->diffInDays($valeur, false);
			$delai = $this->getDelaiExplicite($delai);

			$datas['date'] = $valeur;
			$datas['enclair'] = $enclair;
			$datas['delai'] = $delai;
		}
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

		// dd("delai_explicite : $delai_explicite – prefix : $prefix – chiffre : $chiffre – suffix : $suffix");//CTRL

		return $delai_explicite;
	}


    /**
    * Archivage d'une livraison
    *
    * @param integer  /  id de la livraison
    * 
    * @return boolean
    **/
    public function archiver($id)
    {
    	$this->model = $this->model->findOrFail($id);

    	if ($this->controleAvantArchivage($this->model)) {
        $this->model->statut = 'L_ARCHIVED';
            // dd('archivage ok');
        return $this->model->save();
      }

      return true;
    }


    /**
    * Controle avant archivage d'une livraison ////////////////////// ToDo
    *
    * @param  Model  / Livraison
    * 
    * @return boolean
    **/
    public function controleAvantArchivage($model)
    {
    	$this->message = trans('message.livraison.archivagefailed');
    	return true;
    }


    /**
     * Acquisition de la livraison choisie pour y souscrire une commande.
     * En incluant ses paniers, et pour chacu d'entre eux leproducteur et le prix livraison.
     *
     * @param integer : id de la livraison
     * @return App\Models\Livraison
     **/
    public function creationCommande($id)
    {
      return $this->model->with('panier')->find($id);
    }


    /**
     * Détermination si une commande existe déjà ou non pour (une livraison et un current user) donnés.
     * En incluant ses paniers, et pour chacu d'entre eux leproducteur et le prix livraison.
     *
     * @param integer : id de la livraison | integer : id du client (user)
     * @return false : la livraison à déjà fait l'objet d'une commande par ce client, on la rejette | true : l'inverse, on la garde.
     **/
    public function rejectLivraisonNonOuverteForThisCurrentUser($livraison_id, $user_id)
    {
      $livraison_id;
      $user_id;
      $result = Commande::where([ ['livraison_id', '=', $livraison_id], ['client_id', '=', $user_id] ])->get();
      if ($result->isEmpty()) {
        return false;
      }else{
        return true;
      }
    }


    /**
     * Actualiser le statut des livraisons non archivées par ouverture/sauvegarde.
     *
     * @param integer : id de la livraison | integer : id du client (user)
     * @return false : la livraison à déjà fait l'objet d'une commande par ce client, on la rejette | true : l'inverse, on la garde.
     **/
    public function ActualiserStatut()
    {
      $livraisons = $this->model->where('statut', '<>', 'L_ARCHIVED')->get();
      foreach ($livraisons as $livraison) {
        $livraison->save();
      }
    }

  }
