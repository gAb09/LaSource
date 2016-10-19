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
	protected $model;
    protected $titre_page;
    protected $message;
    protected $restricted_livraisons;
    protected $extended_livraisons;
    protected $action_name_for_view;

    public function __construct(Request $request){
        $this->model = new Indisponibilite;
        $this->request = $request;
    }


    /**
    * Accesseur titre_page.
    * 
    * @return string
    **/
    public function getTitrePage(){
        return $this->titre_page;
    }


    /**
    * Accesseur message.
    * 
    * @return string
    **/
    public function getMessage(){
        return $this->message;
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
    * Accesseur message.
    * 
    * @return string
    **/
    public function getCurrentModel(){
        return $this->model;
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



    public function beforeDestroy($id)
    {
        $this->model = $this->model->find($id);

        /* Y-a-til des livraisons concernées ? */
        if($this->hasLivraisonsConcerned('destroy')){

            /* Il y a des livraisons concernées, alors on redirige vers le formulaire pour les traiter */
            /* Auparavant on conserve les datas utiles à l'action intiale en session */
            $this->keepActionInitialeContext(__FUNCTION__, $id);

            $this->composeDatasForFormLivraisonHandling('la suppression');

            return true;
        }else{
            return false;
        }
    }


    public function destroy($id)
    {
        $this->model = $this->model->find($id);

        if(1==1){
            // if($this->model->delete()){
            $this->message = trans('message.indisponibilite.deleteOk');
            return true;
        }else{
            $this->message = trans('message.indisponibilite.deletefailed');
            return false;
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
    public function hasLivraisonsConcerned($action)
    {
        // return dd($action);
        // return dd($this->request);

        switch ($action) {
            case 'destroy':
            if ($this->hasLivraisonsExtended()) {
                return true;
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
        $collection = $this->listLivraisonsConcerned($__debut, $__fin);
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
         // var_dump("livraison n°$value->id : $value->state");
            return $value->state == 'L_OUVERTE';
        });
        return $new_collection;
    }


    /**
    * Appel du formulaire de traitement des livraisons concernées.
    *
    * @return View
    **/
    public function composeDatasForFormLivraisonHandling($action_name_for_view)
    {
            $this->action_name_for_view = $action_name_for_view;
            $this->titre_page = 'Traitement des livraisons ouvertes concernées par '.$this->titre_page .= $this->action_name_for_view.' de l’indisponibilité de “'.$this->model->indisponible_nom.'”.';
    }


    /**
    * getter indisponible lié.
    * 
    * @return string
    **/
    public function getIndisponibleLied(){
        return $this->model->indisponible;
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