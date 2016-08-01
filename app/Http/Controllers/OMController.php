<?php

namespace App\Http\Controllers;

use App\Models\Relais;
use App\Models\Producteur;
use App\Models\Panier;
use App\Models\Livraison;

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
			$model = new Relais;

			$model->id = $old->id_lieu;
			$model->nom = $old->relais;
			$model->ad1 = $old->ad1;
			$model->ad2 = $old->ad2;
			$model->cp = $old->cp;
			$model->ville = $old->lieu_livraison;
			$model->tel = $old->tel;
			$model->email = $old->mail;
			$model->retrait = $old->horaires;
			$model->ouvertures = $old->remarques;
			$model->is_actif = 1;

			$model->save();
		}
		return redirect()->back();
	}


	public function transfertProducteur()
	{
		$olds = \DB::connection('mysql_old')->table('civam_guide')->select('*')->get();
		foreach ($olds as $old) {
			$model = new Producteur;

			if($old->paniers != '0'){
				$model->id = $old->id_producteur;
				$model->exploitation = $old->exploitation;
				$model->nom = $old->nom;
				$model->prenom = $old->prenom;
				$model->ad1 = $old->adresse;
				$model->ad2 = $old->adresse;
				$model->cp = $old->cp;
				$model->ville = $old->commune;
				$old->tel = str_replace('.', '', $old->tel);
				$model->tel = $old->tel;
				$old->mobile = str_replace('.', '', $old->mobile);
				$model->mobile = $old->mobile;
				if(is_null($old->mail)){
					$model->email = "Inconnu";
				}else{
					$model->email = $old->mail;
				}
				$model->nompourpaniers = $old->paniers;
				$model->is_actif = 1;

				$model->save();
			}
			return redirect()->back();
		}
	}

	public function transfertPanier()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_colis')->select('*')->get();

		foreach ($olds as $old) {
			$model = new Panier;

			$model->id = $old->id_colis;
			$model->type = $old->type_panier;
			$model->famille = $old->ssfamille;
			$model->nom = $old->colis;
			$model->nom_court = $old->colis_abrev;
			$model->idee = $old->idee;
			$model->prix_commun = $old->pu;
			$model->remarques = $old->remarques;
			$model->is_actif = 1;

			$model->save();
		}
		return redirect()->back();
	}

	public function transfertLivraison()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_dates')->select('*')->get();

		foreach ($olds as $old) {
			$model = new Livraison;

			$model->id = $old->id_date;
			$model->date_livraison = $old->livraison;
			$model->date_cloture = $old->cloture_cde;
			$model->date_paiement = $old->cloture_paie;
			$model->created_at = null;
			$model->updated_at = null;
			$model->deleted_at = null;
			$model->is_actif = 1;
			$model->remarques = '';

			$model->save();
		}
		return redirect()->back();
	}

}
