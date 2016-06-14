<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;

use App\Http\Requests;

class OMController extends Controller
{	
	public function index()
	{
		return view('admin.main');
	}


	public function transfertDepots()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_lieux')->select('*')->get();
		foreach ($olds as $old) {
			$depot = new Depot;

			$depot->id = $old->id_lieu;
			$depot->nom = $old->relais;
			$depot->ad1 = $old->ad1;
			$depot->ad2 = $old->ad2;
			$depot->cp = $old->cp;
			$depot->ville = $old->lieu_livraison;
			$depot->tel = $old->tel;
			$depot->email = $old->mail;
			$depot->ouvertures = $old->horaires;
			$depot->remarques = $old->remarques;
			$depot->is_actif = 1;

			$depot->save();
		}
		return redirect()->back();
	}
}
