<?php

namespace App\Domaines;

use App\Models\Indisponibilite;
use App\Domaines\Domaine;
use Carbon\Carbon;

use Log;
use Mail;


class IndisponibiliteDomaine extends Domaine
{
	protected $model;
	protected $titre_page;


	public function __construct(){
		$this->model = new Indisponibilite;
	}


	public function store($request){
		// return dd($request);
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
		// $aucun = array();
		// $this->model = $this->model->findFirst($id);
		// $this->model->panier()->sync($aucun);
		
		// return dd($this->model->delete());
		return false;
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


}