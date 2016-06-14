<?php

namespace App\Http\Controllers;

use App\Models\Relais;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;

use App\Http\Requests;

class OMController extends Controller
{	
	public function index()
	{
		return view('admin.main');
	}


	public function transfertRelais()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_lieux')->select('*')->get();
		foreach ($olds as $old) {
			$relais = new Relais;

			$relais->id = $old->id_lieu;
			$relais->nom = $old->relais;
			$relais->ad1 = $old->ad1;
			$relais->ad2 = $old->ad2;
			$relais->cp = $old->cp;
			$relais->ville = $old->lieu_livraison;
			$relais->tel = $old->tel;
			$relais->email = $old->mail;
			$relais->ouvertures = $old->horaires;
			$relais->remarques = $old->remarques;
			$relais->is_actif = 1;

			$relais->save();
		}
		return redirect()->back();
	}
}
