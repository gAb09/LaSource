<?php

namespace App\Domaines;

use App\Models\Indisponibilite;
use App\Domaines\Domaine;
use App\Domaines\RelaisDomaine as relaisD;
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


    public function __construct(relaisD $relaisD){
        $this->model = new Indisponibilite;
        $this->relaisD = $relaisD;
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
    public function completeCurrentModelWithIndisponisable($id, $type = 'App\Models\Relais'){
        $this->model = $this->model->load(['indisponisable' => function ($query) use ($type){
            $query->where('indisponisable_type', $type);
        }]);
    }



    /**
    * Supplante la fonction create.
    * 
    * @param string $indisponisable_type
    * @param integer $indisponisable_id
    * 
    * @return App\Models\Indisponibilité
    **/
    public function addIndisponibilite($indisponisable_type, $indisponisable_id)
    {     
    /* Renseignement partiel de l'instance courante 
    afin de pouvoir assigner la variable $model 
    du formulaire commun avec l'édition */
    $this->model->indisponisable_type = 'App\Models\\'.$indisponisable_type; // champ indisponisable_type en bdd
    $this->model->indisponisable_id = $indisponisable_id;  // champ indisponisable_id en bdd

    $indisponisable_model = new $this->model->indisponisable_type;
    $indisponisable_model = $indisponisable_model->where('id', $indisponisable_id)->first();
    $this->model->indisponisable_nom = $indisponisable_model->nom;    // champ indisponisable_nom en bdd

    $this->titre_page = 
    trans('titrepage.indisponibilite.create', ['entity' => 'au '.$indisponisable_type, 'nom' => $this->model->indisponisable_nom]);

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


    /**
    * Il y a des livraisons concernées, 
    * alors on prépare les données pour le formulaire de traitement de celles-ci,
    * et aussi la requête sql à fournir ultérieurement pour la transaction.
    **/
    public function beforeStore($request){
        $initial_request = "INSERT INTO indisponibilites (indisponisable_type, indisponisable_id, indisponisable_nom, date_debut, date_fin, cause, remarques) VALUES (";
            $initial_request .= "'".addslashes($request->get('indisponisable_type'))."', '".$request->get('indisponisable_id')."', '".$request->get('indisponisable_nom')."', '".$request->get('date_debut')."', '".$request->get('date_fin')."', '".$request->get('cause')."', '".$request->get('remarques')."')";

$success_message = trans('message.indisponibilite.storeOk');
$action = 'insert';
$this->keepInitialContext($initial_request, $success_message, $action);

$this->action_name_for_view = 'la création';
$this->titre_page = trans("titrepage.livraison.handleIndisponibilities", 
    ['action' => $this->action_name_for_view, 'indisponisable' => $request->get('indisponisable_nom')]);
}



public function edit($id)
{
    return Indisponibilite::with('indisponisable')->where('id', $id)->first();
}



    /**
    * Il y a des livraisons concernées, 
    * alors on prépare les données pour le formulaire de traitement de celles-ci,
    * et aussi la requête sql à fournir ultérieurement pour la transaction.
    **/
    public function beforeUpdate($id, $request)
    {
        $this->extractDoublons();
        $initial_request = "UPDATE indisponibilites SET date_debut = '";
        $initial_request .= $request->get('date_debut');
        $initial_request .= "', date_fin = '";
        $initial_request .= $request->get('date_fin');
        $initial_request .= "', cause = '";
        $initial_request .= $request->get('cause');
        $initial_request .= "', remarques = '";
        $initial_request .= $request->get('remarques');
        $initial_request .= "' WHERE id = ".$id;


        $success_message = trans('message.indisponibilite.updateOk');
        $action = 'update';
        $this->keepInitialContext($initial_request, $success_message, $action);

        $this->action_name_for_view = 'la modification';
        $this->titre_page = trans("titrepage.livraison.handleIndisponibilities", 
            ['action' => $this->action_name_for_view, 'indisponisable' => $request->get('indisponisable_nom')]);
    }



    public function update($id, $request){
        $this->model = Indisponibilite::where('id', $id)->first();
        $this->handleRequest($request);
        $this->message = trans('message.indisponibilite.updateOk');

        return $this->model->save();
    }



    private function handleRequest($request){
        $this->model->indisponisable_id = $request->indisponisable_id;
        $this->model->indisponisable_type = $request->indisponisable_type;
        $this->model->indisponisable_nom = $request->indisponisable_nom;
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
        $action = 'delete';
        $this->keepInitialContext($initial_request, $success_message, $action);

        $this->action_name_for_view = 'la suppression';
        $this->titre_page = trans("titrepage.livraison.handleIndisponibilities", 
            ['action' => $this->action_name_for_view, 'indisponisable' => $this->model->indisponisable_nom]);
    }


    public function destroy($id)
    {
        $this->model = $this->model->find($id);

        if($this->model->delete()){
            $this->message = trans('message.indisponibilite.deleteOk');

            return true;
        }else{
            $this->message = trans('message.indisponibilite.deletefailed');

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
    // return dd($action);
        switch ($action) {
            case 'destroy':
            $this->model = $this->model->find($id);
            if ($this->hasLivraisonsExtended()) {
                $this->beforeDestroy($id);
                return true;
            }else{
                return false;
            }

            case 'store':
            if ($this->hasLivraisonsRestricted($request)) {
                $this->beforeStore($request);
                return true;
            }else{
                return false;
            }

            case 'update':
            $this->model = $this->model->find($id);
            if (!$this->hasLivraisonsExtended()){
                return false;
            }
            if (!$this->hasLivraisonsRestricted($request)){
                return false;
            }

            $this->beforeUpdate($id, $request);
            return true;

            default:
            return dd('hasLivraisonsConcerned, defaut');  // ToDo lancer exception
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
    public function hasLivraisonsRestricted($request)
    {
        $collection = $this->getLivraisonsConcerned($request->get('date_debut'), $request->get('date_fin'));

        if ($collection->isEmpty()) {
            return false;
        }

        $this->restricted_livraisons = $collection;
        return true;
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
    // var_dump('hasLivraisonsExtended');
        $collection = $this->getLivraisonsConcerned($this->model->getOriginal()['date_debut'], $this->model->getOriginal()['date_fin']);

        if ($collection->isEmpty()) {
            return false;
        }

        $this->extended_livraisons = $collection;
        return true;
    }

    /**
    * Suppression des possibles doublons de livraisons
    * livraison(s) dèjà concernée(s) avant update et toujours concernée(s) après)
    * 
    * @param ???????
    * @param ???????
    * 
    **/
    public function extractDoublons()
    {
        $extended = $this->extended_livraisons;
        $restricted = $this->restricted_livraisons;

        if (!is_null($extended)) {
           $this->restricted_livraisons = $this->restricted_livraisons->diff($extended);
       }

        if (!is_null($restricted)) {
           $this->extended_livraisons = $this->extended_livraisons->diff($restricted);
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
    * getter indisponisable lié.
    * 
    * @return string
    **/
    public function getIndisponisableLied($request = null){
        if ($this->model->id)
            { /* Destroy et update */
                return $this->model->indisponisable;
            }else{
                $id = $request->get('indisponisable_id');
                $type = $request->get('indisponisable_type');
                $type = explode("\\", $type);
                $type = strtolower(array_pop($type));
                $type = $type.'D';
                $indisponisable = $this->{$type}->findFirst($id);
                return $indisponisable;
            }
        }



    /**
    * Conservation de la requête de l'action initiale,
    * pour l'ajouter dans la transaction avec les requêtes de traitement des livraisons.
    * 
    * @return string
    **/
    public function keepInitialContext($initial_request, $success_message, $action)
    {
        \Session::set('initialContext.request', $initial_request);
        \Session::set('initialContext.success_message', $success_message);
        \Session::set('initialContext.action', $action);
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