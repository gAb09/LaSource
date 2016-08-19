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


	public function create()
	{
		return $this->model;
	}


	public function store($request){
		// return dd($request);
		\DB::beginTransaction();
		$this->handleRequest($request);
		$this->model->save();
		return $this->handleRequestAttach($request, $this->model->id);
	}


	public function update($id, $request){
		return dd($request);
		$this->model = Fermeture::withTrashed()->where('id', $id)->first();
		$this->handleRequest($request);

		return $this->model->save();
	}


	private function handleRequest($request){
		$this->model->date_debut = $request->date_debut;
		$this->model->date_fin = $request->date_fin;
	}


	private function handleRequestAttach($request, $fermeture_id){
		$relation = strtolower(explode('\\', $request->fermable_type)[2]);
		try{
			$resultat = $this->model->{$relation}()->attach($request->fermable_id, [
				'cause' => $request->cause,
				'remarques' => $request->remarques,
				]);
		} catch(\Illuminate\Database\QueryException $e){
			\DB::rollBack();
			$this->alertOuaibMaistre($e);
			return false;
		}
		\DB::commit();
		return 'ok';
	}


	public function destroy($id)
	{
		if ($result = $this->checkIfImpliedInLivraison($id, 'Suppression')) {
			return($result);
		}
		$aucun = array();
		$this->model = $this->model->where('id', $id)->first();
		$this->model->panier()->sync($aucun);
		
		return $this->model->delete();
	}

	public function alertOuaibMaistre($e)
	{
		Log::info('Problème d\'attachement d\'une fermeture: '.$e);
		// Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
		// 	$m->to = env('MAIL_OM_ADRESS');
		// 	$m->subject($param['subject']);
		// });

	}
}