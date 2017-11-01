<?php

namespace App\Domaines;

use App\Models\Relais;
use App\Domaines\Domaine;


class RelaisDomaine extends Domaine
{
	protected $model;
	protected $liv_concerned;

	public function __construct(){
		$this->model = new Relais;
	}



	public function index(){
		return $models = $this->model->with('indisponibilites')->get();;
	}


	public function store($request){
		$this->handleRequest($request);

		return $this->model->save();
	}


	public function update($id, $request){
		if ($request->input('is_actived') == 0 and $this->hasLiaisonDirecteWithLivraison($id, 'Désactivation')) {
			return false;
		}

		$this->model = Relais::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}

	protected function handleRequest($request){
		$this->model->nom = $request->nom;
		$this->model->retrait = $request->retrait;
		$this->model->ad1 = $request->ad1;
		$this->model->ad2 = $request->ad2;
		$this->model->cp = $request->cp;
		$this->model->ville = $request->ville;
		$this->model->tel = $this->model->cleanTel($request->tel);
		$this->model->email = $request->email;
		$this->model->ouvertures = $request->ouvertures;
		$this->model->remarques = $request->remarques;
		$this->model->is_actived = (isset($request->is_actived)?1:0);
		$new_rang = $this->model->max('rang')+1;
		$this->model->rang = ($request->rang)? $request->rang :$new_rang ;
		$this->model->restore();
	}

	public function destroy($id)
	{
		if ($this->hasLiaisonDirecteWithLivraison($id, 'Suppression')) {
			return false;
		}

		$this->model = $this->model->where('id', $id)->first();
		
		return $this->model->delete();
	}

    /**
    * Post-traitement du formulaire de gestion des livraisons concernées.
    *
    * @param integer $indisponisable_id, Request $request
    * @return boolean
    **/
    public function handleIndisponibilitiesChanges($indisponisable_id, $request)
    {
        $sql_request = \Session::get('initialContext.request');
        $success_message = \Session::get('initialContext.success_message');
        $instruction_SQL = \Session::get('initialContext.instruction');
        $original_model = \Session::get('initialContext.original_model');

        \DB::beginTransaction();

        foreach ($request->get('livraison_id') as $livraison_id => $action) {
            if ($action == 'attach') {
                $this->attachToLivraisons($indisponisable_id, $livraison_id);
            }
            if ($action == 'detach') {
                $this->detachFromLivraisons($indisponisable_id, $livraison_id);
            }
            if ($action == 'reported') {
            	$reported = new \App\Models\IndisponibiliteReported;
            	$reported->livraison_id = $livraison_id;
            	$reported->indisponibilite_id = $original_model['id'];
            	$reported->prev_date_debut = $original_model['date_debut'];
            	$reported->prev_date_fin = $original_model['date_fin'];
            	$reported->prev_cause = $original_model['cause'];
            	$reported->prev_remarques = $original_model['remarques'];
            	// return dd($reported);//CTRL
            	$reported->save();
            }
        }



        if ( \DB::{$instruction_SQL}($sql_request) === 0 or  \DB::{$instruction_SQL}($sql_request) === false) {
            \DB::rollBack();
            $this->message = trans('message.livraison.handleConcernedfailed');
            return false;
        }else{
            \DB::commit();
            $this->message = $success_message.trans('message.livraison.handleConcernedOk');
            return true;
        }
    }


    public function attachToLivraisons($relais_id, $livraison_id)
    {
    	if(!\DB::table('livraison_relais')->whereRelaisId($relais_id)->whereLivraisonId($livraison_id)->count() > 0)
    	{
    		$relais = $this->findFirst($relais_id);
    		return $relais->livraison()->attach($livraison_id);
    	}
    }

    public function detachFromLivraisons($relais_id, $livraison_id)
    {
    	$relais = $this->findFirst($relais_id);
    	return $relais->livraison()->detach($livraison_id);
    }


/**
 * Renvoie tous les relais existants en y précisant les choix par défaut du client loggé
 *
 * @return collection of App\Models\Relais
 **/
    public function getForThisClient($id)
    {
        $models = $this->allActived('id');
        return $models;
    }



}