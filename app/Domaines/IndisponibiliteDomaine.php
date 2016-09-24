<?php

namespace App\Domaines;

use App\Models\Indisponibilite;
use App\Domaines\Domaine;
use App\Models\Livraison;
use Carbon\Carbon;

use Log;
use Mail;


class IndisponibiliteDomaine extends Domaine
{
	protected $model;
	protected $titre_page;
	protected $implied_livraisons;


	public function __construct(){
		$this->model = new Indisponibilite;
	}


	public function store($request){
		$this->handleRequest($request);
		try{
			$this->model->save();
		} catch(\Illuminate\Database\QueryException $e){
			$this->alertOuaibMaistre($e);
			return false;
		}
		return 'ok';
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
		
        return $this->model->delete();
	}




    /**
    * getter $implied_livraisons.
    * 
    * @return collection de model livraison
    **/
    public function getImpliedLivraisons($id){
        $this->model = $this->model->find($id);

        $collection = Livraison::whereBetween('date_livraison', [$this->model->date_debut, $this->model->date_fin])->get();
                $implied_livraisons = $collection->filter(function ($value, $key) {
         // var_dump("livraison n°$value->id : $value->state");
            return $value->state == 'L_OUVERTE';
        });
        return $implied_livraisons;
    }


    /**
    * getter relais lié.
    * 
    * @return string
    **/
    public function getLiedRelais(){
        $relais = $this->model->load('indisponible')->indisponible;
        return $relais;
    }



    public function alertOuaibMaistre($e)
    {
    	$subject = 'Problème lors de l\'attachement d\'une indisponibilité :';
    	Log::info($subject.$e);
		// Mail::send('mails.BugReport', ['e' => $e, 'subject' => $subject], function ($m) use($e, $subject) {
		// 	$m->to = env('MAIL_OM_ADRESS');
		// 	$m->subject($subject);
		// });

    }


    public function addIndisponibilite($indisponible_classe, $indisponible_id)
    {     
    	$this->keepUrlDepart();

    	/* Acquisition d'un modèle d’indisponibilité, même vide, pour renseigner la variable $model du formulaire commun avec l'édition */
    	$indispo = $this->newModel();

    	$indispo->indisponible_type = 'App\Models\\'.$indisponible_classe;
    	$indisponible_model = new $indispo->indisponible_type;
    	$indisponible_model = $indisponible_model->where('id', $indisponible_id)->first();
    	$indispo->indisponible_nom = $indisponible_model->nom;
    	$indispo->indisponible_id = $indisponible_id;
    	return $indispo;

    }



    public function detachIndisponibilite($indisponible_id, Indisponibilite $indisponibilite, $forcage = false)
    {     
    	$this->keepUrlDepart();

    	/* Contrôle si le modèle indisponible est directement lié à une livraison */
    	/* Contrôle si le modèle indisponible est indirectement lié à une livraison (via données dans la table pivot livraison-panier */

    		$indisponible_model = $this->domaine->findFirst($indisponible_id);
    		$model->indisponible_type = get_class($indisponible_model);
    		$model->indisponible_nom = $indisponible_model->nom;
    		$model->indisponible_id = $indisponible_id;


    		$titre_page = trans('titrepage.indisponibilite.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->indisponible_nom]);

    		return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    	}

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