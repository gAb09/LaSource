<?php

namespace App\Http\Controllers;

use App\Models\Relais;
use App\Models\Producteur;

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
			$relais->retrait = $old->horaires;
			$relais->ouvertures = $old->remarques;
			$relais->is_actif = 1;

			$relais->save();
		}
		return redirect()->back();
	}


	public function transfertProducteur()
	{
		$olds = \DB::connection('mysql_old')->table('civam_guide')->select('*')->get();
		foreach ($olds as $old) {
			$producteur = new Producteur;
			if($old->paniers != '0'){
				$producteur->id = $old->id_producteur;
				$producteur->exploitation = $old->exploitation;
				$producteur->nom = $old->nom;
				$producteur->prenom = $old->prenom;
				$producteur->ad1 = $old->adresse;
				$producteur->ad2 = $old->adresse;
				$producteur->cp = $old->cp;
				$producteur->ville = $old->commune;
				$old->tel = str_replace('.', '', $old->tel);
				$producteur->tel = $old->tel;
				$old->mobile = str_replace('.', '', $old->mobile);
				$producteur->mobile = $old->mobile;
				if(is_null($old->mail)){
					$producteur->email = "Inconnu";
				}else{
					$producteur->email = $old->mail;
				}
				$producteur->nompourpaniers = $old->paniers;
				$producteur->is_actif = 1;

				$producteur->save();
			}
		}
		return redirect()->back();
	}
}
