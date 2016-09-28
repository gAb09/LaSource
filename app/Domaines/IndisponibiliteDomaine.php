<?php

namespace App\Domaines;

use App\Models\Indisponibilite;
use App\Domaines\Domaine;
use App\Models\Livraison;
use Carbon\Carbon;
use App\Exceptions\IndispoControleLivraisonException;

use Log;
use Mail;


class IndisponibiliteDomaine extends Domaine
{
	protected $model;
    protected $titre_page;
    protected $message;
    protected $restricted_livraisons;
    protected $expanded_livraisons;


    public function __construct(){
      $this->model = new Indisponibilite;
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
    * Accesseur message.
    * 
    * @return string
    **/
    public function gecurrentModel(){
        return $this->model;
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
        $this->keepUrlDepart();

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



  public function destroy($id)
  {
      $this->model = $this->model->find($id);
      $this->message = trans('message.indisponibilite.deleteOk');

      return $this->model->delete();
  }



    /**
    * Conservation de l'instance de l'indisponibilité courante en session.
    * Précaution pour le cas où le gestionnaire opterait pour un traitement manuel.
    * 
    **/
    public function keepIndispo(){
        \Session::set('CurrentIndispo', $this->model);
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
    public function checkIfLivraisonsRestricted($date_debut, $date_fin)
    {
        $collection = Livraison::whereBetween('date_livraison', [$date_debut, $date_fin])->get();
        $this->restricted_livraisons = $collection->filter(function ($value, $key) {
         // var_dump("livraison n°$value->id : $value->state");
            return $value->state == 'L_OUVERTE';
        });
        return true;
    }



    /**
    * Recherche d'éventuelles livraisons dont la date de livraison est comprise entre les ANCIENNES dates de début et de fin de l'indisponibilité.
    * S'il y en a, stockage de la collection de livraisons dans la propriété $expanded_livraisons.
    * 
    * @param Carbon date debut
    * @param Carbon date fin
    * 
    * @return boolean
    **/
    public function checkIfLivraisonsExtended($date_debut, $date_fin)
    {
        $collection = Livraison::whereBetween('date_livraison', [$date_debut, $date_fin])->get();
        $this->expanded_livraisons = $collection->filter(function ($value, $key) {
         // var_dump("livraison n°$value->id : $value->state");
            return $value->state == 'L_OUVERTE';
        });
        return true;
    }



    public function handleLivraisonAffected()
    {
        $this->titre_page = 'Traitement des livraisons ouvertes concernées par le changement de disponibilité de “'.$this->model->indisponible_nom.'”.';

        $datas = array();
        $datas['restricted_livraisons'] = $this->restricted_livraisons;
        $datas['expanded_livraisons'] = $this->expanded_livraisons;
        $datas['indisponible'] = $this->getIndisponibleLied();


        // return dd($datas);
        return $datas;
        // throw new IndispoControleLivraisonException('test');
    }




    /**
    * getter indisponible lié.
    * 
    * @return string
    **/
    public function getIndisponibleLied(){
        $instance = $this->model->load('indisponible')->indisponible;
        return $instance;
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


    /* - - - - - - - - - - - - - A passer dans controller::class - - - - - - - - - - - - - - - - - */

    /**
    * Conservation de l'url de la page de départ.
    * 
    **/
    public function keepUrlDepart(){
        if (!\Session::has('url_depart_ajout_indisponibilite')) {
            \Session::set('url_depart_ajout_indisponibilite', \Session::get('_previous.url'));
        }
    }



}