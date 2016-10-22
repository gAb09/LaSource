<?php

namespace App\Domaines;

use App\Models\Indisponibilite;
use App\Domaines\Domaine;
use App\Models\Livraison;
use Carbon\Carbon;
use App\Exceptions\IndispoControleLivraisonException;

use Illuminate\Http\Request;
use Log;
use Mail;


class IndisponibiliteDomaine extends Domaine
{

    protected $restricted_livraisons;
    protected $extended_livraisons;
    protected $action_name_for_view;


    public function __construct(){
        $this->model = new Indisponibilite;
    }


    /**
    * Accesseur nom de l'action en clair pour affichage dans la vue.
    * 
    * @return string
    **/
    public function getActionNameForView(){
        return $this->action_name_for_view;
    }


    /**
    * Accesseur pour la collection des livraisons resreintes.
    * 
    * @return colection
    **/
    public function getRestrictedLivraisons(){
        return $this->restricted_livraisons;
    }


    /**
    * Accesseur pour la collection des livraisons étendues.
    * 
    * @return colection
    **/
    public function getExtendedLivraisons(){
        return $this->extended_livraisons;
    }


    /**
    * ToDo.
    * 
    * @return string
    **/
    public function completeCurrentModelWithIndisponible($id, $type = 'App\Models\Relais'){
        $this->model = $this->model->load(['indisponible' => function ($query) use ($type){
            $query->where('indisponible_type', $type);
        }]);
    }



    /**
    * Supplante la fonction create.
    * 
    * @param string $indisponible_type
    * @param integer $indisponible_id
    * 
    * @return App\Models\Indisponibilité
    **/
    public function addIndisponibilite($indisponible_type, $indisponible_id)
    {     
            /* Renseignement partiel de l'instance courante 
            afin de pouvoir assigner la variable $model 
            du formulaire commun avec l'édition */
            $this->model->indisponible_type = 'App\Models\\'.$indisponible_type; // champ indisponible_type en bdd
            $this->model->indisponible_id = $indisponible_id;  // champ indisponible_id en bdd

            $indisponible_model = new $this->model->indisponible_type;
            $indisponible_model = $indisponible_model->where('id', $indisponible_id)->first();
            $this->model->indisponible_nom = $indisponible_model->nom;    // champ indisponible_nom en bdd

            $this->titre_page = 
            trans('titrepage.indisponibilite.create', ['entity' => 'au '.$indisponible_type, 'nom' => $this->model->indisponible_nom]);

            return $this->model;
        }



    /**
    * @param Request
    * 
    * @return boolean
    **/
    public function store($request){
      $this->handleRequest($request);

      try{
         $this->model->save();
		} catch(\Illuminate\Database\QueryException $e){ // ToDo revoir si gestion erreur ok
            $this->message = trans('message.indisponibilite.storefailed').trans('message.bug.transmis');
            $this->alertOuaibMaistre($e);
            return false;
        }
        $this->message = trans('message.indisponibilite.storeOk');
        return true;
    }



    public function edit($id)
    {
        return Indisponibilite::with('indisponible')->where('id', $id)->first();
    }




    public function update($id, $request){
        $this->model = Indisponibilite::where('id', $id)->first();
        $this->handleRequest($request);

        return $this->model->save();
    }



    private function handleRequest($request){
        $this->model->indisponible_id = $request->indisponible_id;
        $this->model->indisponible_type = $request->indisponible_type;
        $this->model->indisponible_nom = $request->indisponible_nom;
        $this->model->date_debut = $request->date_debut;
        $this->model->date_fin = $request->date_fin;
        $this->model->cause = $request->cause;
        $this->model->remarques = $request->remarques;
    }



    /**
    * Il y a des livraisons concernées, 
    * alors on prépare les données pour le formulaire de traitement de celles-ci,
    * et aussi la requête sql à fournir ultérieurement pour la transaction.
    **/
    public function beforeDestroy($id)
    {
            $initial_request = 'delete from `indisponibilites` where `id` = '.$id;
            $success_message = trans('message.indisponibilite.deleteOk');
            $this->keepInitialContext($initial_request, $success_message);

            $this->action_name_for_view = 'la suppression';
            $this->titre_page = trans("titrepage.livraison.handleIndisponibilities", 
                ['action' => $this->action_name_for_view, 'indisponisable' => $this->model->indisponible_nom]);
    }


    public function destroy($id)
    {
        $this->model = $this->model->find($id);

        if($this->model->delete()){
            $this->message = trans('message.indisponibilite.deleteOk');
            return dd($this->message);//CTRL
            return true;
        }else{
            $this->message = trans('message.indisponibilite.deletefailed');
            return dd($this->message);//CTRL
            return true;
        }
    }


    /**
    * Recherche de livraisons OUVERTES qui se trouvent étendues ou restreintes.
    * Le cas échéant, constitution des listes de ces livraisons
    * 
    * @param string - action courante
    * 
    * @return boolean
    **/
    public function hasLivraisonsConcerned($action, $id, $request = null)
    {
        $this->model = $this->model->find($id);

        switch ($action) {
            case 'destroy':
            if ($this->hasLivraisonsExtended()) {
                $this->beforeDestroy($id);
                return true;
            }else{
                return false;
            }
            
            case 'create':
            if ($this->hasLivraisonsRestricted()) {
                $this->beforeCreate($id, $request);
                return true;
            }else{
                return false;
            }
            
            case 'update':
            if ($this->hasLivraisonsExtended() or $this->hasLivraisonsRestricted()) {
                $this->beforeUpdate($id, $request);
                return true;
            }else{
                return false;
            }
            
            return dd('hasLivraisonsConcerned, defaut');  // ToDo lancer exception
            break;
        }
    }




    /**
    * Recherche d'éventuelles livraisons dont la date de livraison est comprise entre les NOUVELLES dates de début et de fin de l'indisponibilité.
    * S'il y en a, stockage de la collection de livraisons dans la propriété $restricted_livraisons.
    * 
    * @param Carbon date debut
    * @param Carbon date fin
    * 
    * @return boolean
    **/
    public function hasLivraisonsRestricted()
    {

        $collection = $this->getLivraisonsConcerned($__debut, $__fin);
        if ($collection->isEmpty()) {
            return false;
        }else{
            $this->restricted_livraisons = $collection;
            return true;
        }
    }



    /**
    * Recherche d'éventuelles livraisons dont la date de livraison est comprise entre les ANCIENNES dates de début et de fin de l'indisponibilité.
    * S'il y en a, stockage de la collection de livraisons dans la propriété $extended_livraisons.
    * 
    * @param Carbon date debut
    * @param Carbon date fin
    * 
    * @return boolean
    **/
    public function hasLivraisonsExtended()
    {
        $collection = $this->getLivraisonsConcerned($this->model->date_debut, $this->model->date_fin);

        if ($collection->isEmpty()) {
            return false;
        }else{
            $this->extended_livraisons = $collection;
            return true;
        }
    }



    /**
    * Recherche de livraisons OUVERTES dont la date de livraison se situe entre les dates fournies en argument.
    * 
    * @param Carbon date debut
    * @param Carbon date fin
    * 
    * @return collection de Model\Livraison
    **/
    public function getLivraisonsConcerned($date_debut, $date_fin)
    {
        $collection = Livraison::whereBetween('date_livraison', [$date_debut, $date_fin])->get();

        $new_collection = $collection->filter(function ($value, $key) {
            return $value->state == 'L_OUVERTE';
        });
        return $new_collection;
    }



    /**
    * getter indisponible lié.
    * 
    * @return string
    **/
    public function getIndisponibleLied(){
        return $this->model->indisponible;
    }


    /**
    * Conservation de la requête de l'action initiale,
    * pour l'ajouter dans la transaction avec les requêtes de traitement des livraisons.
    * 
    * @return string
    **/
    public function keepInitialContext($initial_request, $success_message)
    {
        \Session::set('initialContext.request', $initial_request);
        \Session::set('initialContext.success_message', $success_message);
    }



    /* - - - - - - - - - - - - - ToDo - - - - - - - - - - - - - - - - - */

    public function alertOuaibMaistre($e)
    {
    	$subject = 'Problème lors de l\'attachement d\'une indisponibilité :';
    	Log::info($subject.$e);
		// Mail::send('mails.BugReport', ['e' => $e, 'subject' => $subject], function ($m) use($e, $subject) {
		// 	$m->to = env('MAIL_OM_ADRESS');
		// 	$m->subject($subject);
		// });
    }

}