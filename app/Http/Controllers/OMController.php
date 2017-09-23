<?php

namespace App\Http\Controllers;

use App\Models\Relais;
use App\Models\Producteur;
use App\Models\Panier;
use App\Models\Livraison;
use App\Models\Commande;
use App\Models\Ligne;
use App\Models\ModePaiement;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

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
			$model->is_actived = 1;

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
				$model->is_actived = 1;

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
			$model->prix_base = $old->pu;
			$model->remarques = $old->remarques;
			$model->is_actived = 1;

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
			$model->is_actived = 1;
			$model->remarques = '';

			$model->save();
		}
		return redirect()->back();
	}


	public function transfertCommandes()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_commandes')->select('*')->get();

		foreach ($olds as $old) {
			$model = new Commande;

			$model->id = $old->id_commande;
			$model->livraison_id = $old->id_date;
			$model->client_id= trim($old->numero_client, 'C');
			$model->numero = $old->numero_commande;
			$model->created_at = $old->date_creation;
			if ($old->date_modif != '0000-00-00') {
				$model->updated_at = $old->date_modif;
			}else{
				$model->updated_at = '0';
			}
			$model->relais_id = $this->transcode_oldrelais($old->lieu_livraison);
			$model->modepaiement_id = $this->transcode_modepaiement($old->mode_reglement);
			$model->is_paid = $old->paiement_ok;
			$model->is_livred = $old->livraison_ok;
			$model->is_retired = $old->retrait_ok;
			$model->is_actived = 1;
			$model->remarques = '';

			$lignes = $this->RecompositionLignesDeLaCommande($old);

			$model->save();
			$model->lignes()->saveMany($lignes);

		}

		// return redirect()->back();
		return var_dump('fini');
	}



	private function transcode_modepaiement($modepaiement)
	{
		if ($modepaiement == 'chèque') {
			return ModePaiement::where('nom', 'Chèque')->first()->id;
		}elseif ($modepaiement == 'virement') {
			return ModePaiement::where('nom', 'Virement')->first()->id;
		}
		return ModePaiement::where('nom', 'Problème')->first()->id;
	}



	private function transcode_oldrelais($ville)
	{
		switch ($ville) {
			case 'Foix':
				return 9;
				break;
			
			case 'La Bastide de Sérou':
				return 10;
				break;
			
			case 'Pamiers':
				return 11;
				break;
			
			case 'Saint-Girons':
				return 12;
				break;
			
			default:
				return 13;
				break;
		}
	}

	private function RecompositionLignesDeLaCommande($commande)
	{
		$lignes=array();

		// Mis en tableau des colonnes de la table
		$colonnes = get_object_vars($commande);

		foreach ($colonnes as $colonne => $valeur) {

			// Détection des colonnes concernant les quantités des lignes de la commande
			if (substr_count($colonne, 'ligne') == 1 and substr_count($colonne, '_qte') == 1) {

				// Détection si quantité valide
				if (is_integer($valeur) and $valeur != 0) {
					// Récupération du numéro de la ligne
					$retrait = ['ligne' => '', '_qte' => ''];
					$numeroLigne = strtr($colonne, $retrait);
					$lignes[] = $this->RecompositionLigne($numeroLigne, $commande);
				}
			}
		}
		return $lignes;
	}

	private function RecompositionLigne($numeroLigne, $commande)
	{
		$ligne = new Ligne;

		$NameColonneQuantite = 'ligne'.$numeroLigne.'_qte';
		$NameColonnePanier = 'ligne'.$numeroLigne.'_colis';

		$ligne->quantite = $commande->$NameColonneQuantite;
		$ligne->panier_id = $commande->$NameColonnePanier;
		// $ligne->commande_id = $commande->id_commande;

		return $ligne;
	}


}
