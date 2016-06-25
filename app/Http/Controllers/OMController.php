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
			$item = new Relais;

			$item->id = $old->id_lieu;
			$item->nom = $old->item;
			$item->ad1 = $old->ad1;
			$item->ad2 = $old->ad2;
			$item->cp = $old->cp;
			$item->ville = $old->lieu_livraison;
			$item->tel = $old->tel;
			$item->email = $old->mail;
			$item->retrait = $old->horaires;
			$item->ouvertures = $old->remarques;
			$item->is_actif = 1;

			$item->save();
		}
		return redirect()->back();
	}


	public function transfertProducteur()
	{
		$olds = \DB::connection('mysql_old')->table('civam_guide')->select('*')->get();
		foreach ($olds as $old) {
			$item = new Producteur;

			if($old->paniers != '0'){
				$item->id = $old->id_item;
				$item->exploitation = $old->exploitation;
				$item->nom = $old->nom;
				$item->prenom = $old->prenom;
				$item->ad1 = $old->adresse;
				$item->ad2 = $old->adresse;
				$item->cp = $old->cp;
				$item->ville = $old->commune;
				$old->tel = str_replace('.', '', $old->tel);
				$item->tel = $old->tel;
				$old->mobile = str_replace('.', '', $old->mobile);
				$item->mobile = $old->mobile;
				if(is_null($old->mail)){
					$item->email = "Inconnu";
				}else{
					$item->email = $old->mail;
				}
				$item->nompourpaniers = $old->paniers;
				$item->is_actif = 1;

				$item->save();
			}
			return redirect()->back();
		}
	}

	public function transfertPanier()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_colis')->select('*')->get();

		foreach ($olds as $old) {
			$item = new Panier;

			$item->id = $old->id_colis;
			$item->type = $old->type_panier;
			$item->famille = $old->ssfamille;
			$item->nom = $old->colis;
			$item->nom_court = $old->colis_abrev;
			$item->idee = $old->idee;
			$item->prix_commun = $old->pu;
			$item->remarques = $old->remarques;
			$item->is_actif = 1;

			$item->save();
		}
		return redirect()->back();
	}

	public function transfertLivraison()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_dates')->select('*')->get();

		foreach ($olds as $old) {
			$item = new Livraison;

			$item->id = $old->id_date;
			$item->date_livraison = $old->livraison;
			$item->date_cloture = $old->cloture_cde;
			$item->date_paiement = $old->cloture_paie;
			$item->created_at = null;
			$item->updated_at = null;
			$item->deleted_at = null;
			$item->is_actif = 1;
			$item->remarques = '';

			$item->save();
		}
		return redirect()->back();
	}

}
