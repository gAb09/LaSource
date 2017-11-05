<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientDomaine extends Domaine
{

	public function __construct(){
		$this->model = new Client;
	}

	/**
	 *
	 * @param Integer : nombre de clients par page.
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function index($pages = 10){
		$clients = $this->model->orderBy('id', 'DESC')->paginate($pages);

		return $clients;
	}


	public function setPrefRelais($relais_id){
		$user = \Auth::user()->id;
		$model = $this->model->find($user);
		$model->pref_relais = $relais_id;
		// return dd($model->save());

		try{
			$model->save();
		} 
		catch(\Illuminate\Database\QueryException $e){ // ToDo revoir si gestion erreur ok
			$this->message = trans('message.client.setPrefRelaisFailed').trans('message.bug.transmis');
			// $this->alertOuaibMaistre($e);
			return '<div class="alert alert-danger">'.$this->message.'</div>';
		}
		$this->message = trans('message.client.setPrefRelaisOK');
		return '<div class="alert alert-success">'.$this->message.'</div>';

	}



	public function setPrefPaiement($paiement_id){
		$user = \Auth::user()->id;
		$model = $this->model->find($user);
		$model->pref_paiement = $paiement_id;
		// return dd($model->save());

		try{
			$model->save();
		} 
		catch(\Illuminate\Database\QueryException $e){ // ToDo revoir si gestion erreur ok
			$this->message = trans('message.client.setPrefPaiementFailed').trans('message.bug.transmis');
			// $this->alertOuaibMaistre($e);
			return '<div class="alert alert-danger">'.$this->message.'</div>';
		}
		$this->message = trans('message.client.setPrefPaiementOK');
		return '<div class="alert alert-success">'.$this->message.'</div>';

	}

}
