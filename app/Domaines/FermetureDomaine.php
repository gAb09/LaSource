<?php

namespace App\Domaines;

use App\Models\Fermeture;
use App\Domaines\Domaine;

use Log;
use Mail;


class FermetureDomaine extends Domaine
{
	protected $model;
	protected $titre_page;


	public function __construct(){
		$this->model = new Fermeture;
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


	public function update($id, $request){
		return dd($request);
		$this->model = Fermeture::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->fermable_id = $request->fermable_id;
		$this->model->fermable_type = $request->fermable_type;
		$this->model->date_debut = $request->date_debut;
		$this->model->date_fin = $request->date_fin;
		$this->model->cause = $request->cause;
		$this->model->remarques = $request->remarques;
	}



	public function destroy($id)
	{
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		$this->model->panier()->sync($aucun);
		
		return dd($this->model->delete());
	}



	public function alertOuaibMaistre($e)
	{
		$subject = 'Problème d\'attachement d\'une fermeture :';
		Log::info($subject.$e);
		// Mail::send('mails.BugReport', ['e' => $e, 'subject' => $subject], function ($m) use($e, $subject) {
		// 	$m->to = env('MAIL_OM_ADRESS');
		// 	$m->subject($subject);
		// });

	}

}