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
    public $indisponisable_lied;
    public $action_name_for_view;


    public function __construct(){
        $this->restricted_livraisons = collect([]);
        $this->extended_livraisons = collect([]);
        $this->model = new Indisponibilite;
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
    * Supplante la fonction create.
    * 
    * @param string $indisponisable_type
    * @param integer $indisponisable_id
    * 
    * @return App\Models\Indisponibilité
    **/
    public function addIndisponibilite($indisponisable_type, $indisponisable_id){     
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
        $request_SQL = "INSERT INTO indisponibilites ";
        $request_SQL .= "(indisponisable_type, indisponisable_id, indisponisable_nom, date_debut, date_fin, cause, remarques)";
        $request_SQL .= " VALUES ('";
        $request_SQL .= addslashes($request->get('indisponisable_type'));
        $request_SQL .= "', '";
        $request_SQL .= $request->get('indisponisable_id');
        $request_SQL .= "', '";
        $request_SQL .= $request->get('indisponisable_nom');
        $request_SQL .= "', '".$request->get('date_debut');
        $request_SQL .= "', '";
        $request_SQL .= $request->get('date_fin');
        $request_SQL .= "', '";
        $request_SQL .= $request->get('cause');
        $request_SQL .= "', '";
        $request_SQL .= $request->get('remarques');
        $request_SQL .= "')";

        $success_message = trans('message.indisponibilite.storeOk');
        $instruction_SQL = 'insert';
        $this->keepInitialContext($request_SQL, $success_message, $instruction_SQL);

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
        if ($this->hasConcernedLivraisonsAfterDoublonsExtraction()){

            $request_SQL = "UPDATE indisponibilites SET date_debut = '";
            $request_SQL .= $request->get('date_debut');
            $request_SQL .= "', date_fin = '";
            $request_SQL .= $request->get('date_fin');
            $request_SQL .= "', cause = '";
            $request_SQL .= $request->get('cause');
            $request_SQL .= "', remarques = '";
            $request_SQL .= $request->get('remarques');
            $request_SQL .= "' WHERE id = ".$id;

            $success_message = trans('message.indisponibilite.updateOk');
            $instruction_SQL = 'update';
            $this->keepInitialContext($request_SQL, $success_message, $instruction_SQL);

            $this->action_name_for_view = 'la modification';
            $this->titre_page = trans("titrepage.livraison.handleIndisponibilities", 
                ['action' => $this->action_name_for_view, 'indisponisable' => $request->get('indisponisable_nom')]);

            return true;
        }else{
            return false;
        }
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
    public function beforeDelete($id)
    {
        $request_SQL = 'delete from `indisponibilites` where `id` = '.$id;
        $success_message = trans('message.indisponibilite.deleteOk');
        $instruction_SQL = 'delete';
        $this->keepInitialContext($request_SQL, $success_message, $instruction_SQL);

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
    public function hasConcernedLivraisons($request, $id = null)
    {
        $method = (!is_null($request->get('_method'))) ? strtolower($request->get('_method')): 'store';
        $date_debut = $request->get('date_debut');
        $date_fin = $request->get('date_fin');
        if(!is_null($id)){
            $this->model = $this->model->with('indisponisable')->find($id);
        }

        switch ($method) {
            case 'delete':
            $this->setExtendedLivraisons($this->model->date_debut, $this->model->date_fin);

            if(!$this->extended_livraisons->isEmpty()){
                $this->setIndisponisableLied();
                $this->beforeDelete($id);
                return true;
            }else{
                return false;
            }

            case 'store':
            $this->setRestrictedLivraisons($request->get('date_debut'), $request->get('date_fin'));

            if(!$this->restricted_livraisons->isEmpty()){
                $this->setIndisponisableLied($request);
                $this->beforeStore($request);
                return true;
            }else{
                return false;
            }

            case 'put':
            $this->setExtendedLivraisons($this->model->date_debut, $this->model->date_fin);
            $this->setRestrictedLivraisons($request->get('date_debut'), $request->get('date_fin'));

            if(!$this->extended_livraisons->isEmpty() or !$this->restricted_livraisons->isEmpty()){
                $this->setIndisponisableLied();
                return $this->beforeUpdate($id, $request);
            }else{
                return false;
            }

            default:
            return dd('hasConcernedLivraisons, defaut');  // ToDo lancer exception
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
    public function setRestrictedLivraisons($date_debut, $date_fin)
    {
        $this->restricted_livraisons = $this->getConcernedLivraisons($date_debut, $date_fin);
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
    public function setExtendedLivraisons($date_debut, $date_fin)
    {
        $this->extended_livraisons = $this->getConcernedLivraisons($date_debut, $date_fin);;
    }



    /**
    * Suppression des possibles doublons de livraisons
    * livraison(s) dèjà concernée(s) avant update et toujours concernée(s) après.
    * 
    * @param ???????
    * @param ???????
    * 
    **/
    public function hasConcernedLivraisonsAfterDoublonsExtraction()
    {
        $extended = $this->extended_livraisons;
        $restricted = $this->restricted_livraisons;

        if (!is_null($extended)) {
            $this->restricted_livraisons = $this->restricted_livraisons->diff($extended);
        }

        if (!is_null($restricted)) {
            $this->extended_livraisons = $this->extended_livraisons->diff($restricted);
        }

        if ($this->extended_livraisons->isEmpty() and $this->extended_livraisons->isEmpty()) {
            return false;
        }else{
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
    public function getConcernedLivraisons($date_debut, $date_fin)
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
    public function setIndisponisableLied($request = null){
        if (is_null($request))
        {
            $this->indisponisable_lied = $this->model->indisponisable;
        }else{
            $id = $request->get('indisponisable_id');
            $type = $request->get('indisponisable_type');
            $type = explode("\\", $type);
            $type = array_pop($type);
            $type = '\\App\\Domaines\\'.$type.'Domaine';
            $indisponisable = new $type;
            $this->indisponisable_lied = $indisponisable->findFirst($id);
        }
    }



    /**
    * Conservation du contexte initial :
    * – la requête pour l'ajouter dans la transaction aux requêtes de traitement des livraisons.
    * – l'instruction sql pour l'ajouter dans la transaction aux requêtes de traitement des livraisons.
    * – la requête pour l'ajouter dans la transaction aux requêtes de traitement des livraisons.
    * 
    * @return string
    **/
    public function keepInitialContext($request_SQL, $success_message, $instruction_SQL)
    {
        \Session::set('initialContext.request', $request_SQL);
        \Session::set('initialContext.success_message', $success_message);
        \Session::set('initialContext.instruction', $instruction_SQL);
    }



    /* - - - - - - - - - - - - - ToDo - - - - - - - - - - - - - - - - - */

    public function alertOuaibMaistre($e)
    {
        $subject = 'Problème lors de l\'attachement d\'une indisponibilité :';
        Log::info($subject.$e);
    // Mail::send('mails.BugReport', ['e' => $e, 'subject' => $subject], function ($m) use($e, $subject) {
    //  $m->to = env('MAIL_OM_ADRESS');
    //  $m->subject($subject);
    // });
    }
}