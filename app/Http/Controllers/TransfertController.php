<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
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

class TransfertController extends Controller
{
	public function index()
	{
		return view('admin.main');
	}


	public function user()
	{
		foreach ($olds as $old) {
			$model = new User;

			$model->id = $old->id_client;
			$model->pseudo = $old->login_client;
			$model->email = $old->email;
			$model->role_id = 10;
			$model->created_at = $this->checkAndReformateDate($old->date_creation);
			$model->updated_at = $this->checkAndReformateDate($old->date_modif);

				$model->save();
		}
	}


	public function client()
	{
		\DB::transaction(function(){

			$olds = \DB::connection('mysql_old')->table('paniers_clients')->select('*')->get();

			$this->user();

			foreach ($olds as $old) {
				$model = new Client;

				$model->id = $old->id_client;
				$model->user_id = $old->id_client;
				$model->nom = $old->nom;
				$model->prenom = $old->prenom;
				$model->ad1 = $old->ad1;
				$model->ad2 = $old->ad2;
				$model->cp = $old->cp;
				$model->ville = $old->ville;
				$model->tel = $this->reformateTel($old->telephone);
				$model->mobile = $this->reformateTel($old->mobile);
				$model->created_at = $this->checkAndReformateDate($old->date_creation);
				$model->updated_at = $this->checkAndReformateDate($old->date_modif);

				$model->save();
			}
		});

		return redirect()->back();
	}

	public function relais()
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
			$model->tel = $this->reformateTel($old->tel);
			$model->email = $old->mail;
			$model->retrait = $old->horaires;
			$model->ouvertures = $old->remarques;
			$model->is_actived = 1;
			$model->created_at = $this->checkAndReformateDate();
			$model->updated_at = $this->checkAndReformateDate();

			$model->save();
		}
		return redirect()->back();
	}



	public function producteurs()
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
				$model->tel = $this->reformateTel($old->tel);
				$model->mobile = $this->reformateTel($old->mobile);
				if(is_null($old->mail)){
					$model->email = "Inconnu";
				}else{
					$model->email = $old->mail;
				}
				$model->nompourpaniers = $old->paniers;
				$model->is_actived = 1;
				$model->created_at = $this->checkAndReformateDate();
				$model->updated_at = $this->checkAndReformateDate();

				$model->save();
			}
			return redirect()->back();
		}
	}

	public function paniers()
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
			$model->created_at = $this->checkAndReformateDate();
			$model->updated_at = $this->checkAndReformateDate();

			$model->save();
		}
		return redirect()->back();
	}

	public function livraisons()
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
			$model->statut = "L_ARCHIVED";
			$model->remarques = '';
			$model->created_at = $this->checkAndReformateDate();
			$model->updated_at = $this->checkAndReformateDate();

			$model->save();
		}
		return redirect()->back();
	}


	public function commandes()
	{
		$olds = \DB::connection('mysql_old')->table('paniers_commandes')->select('*')->get();
		try{
			\DB::beginTransaction();

			foreach ($olds as $old) {
				if (!empty($old->id_date) and is_numeric($old->id_date)) {
					$model = new Commande;

					$model->id = $old->id_commande;
					$model->livraison_id = $old->id_date;
					$model->client_id= trim($old->numero_client, 'C');
					$model->numero = $old->numero_commande;
					$model->relais_id = $this->transcodeRelais($old->lieu_livraison);
					$model->modepaiement_id = $this->transcodeModepaiement($old->mode_reglement);
					$model->is_paid = $old->paiement_ok;
					$model->is_livred = $old->livraison_ok;
					$model->is_retired = $old->retrait_ok;
					$model->is_actived = 1;
					$model->statut = "C_ARCHIVABLE";
					$model->remarques = '';
					$model->created_at = checkAndReformateDate($old->date_creation);
					$model->updated_at = checkAndReformateDate($old->date_modif);


					$lignes = $this->transpositionLignes($old);


					$model->save();
					$model->lignes()->saveMany($lignes);
					$this->actualisePivotLivraisonPanier($lignes, $old);
				}
			}
		}
		catch(\exception $e){
			\DB::rollBack();
			return redirect('transfert')->with('status', 'Problème : '.$e->getMessage());
		}

		\DB::commit();
		return redirect()->back()->with('success', 'transfert des commandes effectué');
	}



	private function reformateTel($tel)
	{
		$newtel = str_replace('.', '', $tel);
		$newtel = str_replace(' ', '', $tel);

		return $newtel;
	}


	private function transcodeModepaiement($modepaiement)
	{
		if ($modepaiement == 'chèque') {
			return ModePaiement::where('nom', 'Chèque')->first()->id;
		}elseif ($modepaiement == 'virement') {
			return ModePaiement::where('nom', 'Virement')->first()->id;
		}
		return ModePaiement::where('nom', 'Problème')->first()->id;
	}



	private function transcodeRelais($ville)
	{
		switch ($ville) {
			case 'Foix':
			return 1;
			break;

			case 'La Bastide de Sérou':
			return 2;
			break;

			case 'Pamiers':
			return 3;
			break;

			case 'Saint-Girons':
			return 4;
			break;

			case 'Lavelanet':
			return 7;
			break;

			default:
			return 5;
			break;
		}
	}


	/**
	 * Passer les colonnes en revues, s'il s'agit d'une colonne persistant une quantité (non égale à 0),
	 * obtenir le numéro de la ligne, vérifier la conformité de la quantité,
	 * et reconstituer ainsi chaque ligne sous sa nouvelle forme.
	 *
	 * @param stdClass
	 * @return Array - Les lignes de la commande
	 **/
	private function transpositionLignes($commande_old)
	{
		$lignes=array();

		// Mis en tableau des colonnes de la table
		$colonnes = get_object_vars($commande_old);

		foreach ($colonnes as $colonne => $valeur) {

			// Détection des colonnes concernant les quantités des lignes de la commande
			if (substr_count($colonne, 'ligne') == 1 and substr_count($colonne, '_qte') == 1) {

				if ($valeur != 0) { // Si la quantité est 0 on ne traite pas cette ligne

					// Obtention du numéro de la ligne
					$txt_a_retirer = ['ligne' => '', '_qte' => ''];
					$numeroLigne = strtr($colonne, $txt_a_retirer);

					// Recomposition ligne si quantité valide
					if (is_integer($valeur)){
						$lignes[] = $this->recompositionLigne($numeroLigne, $commande_old);
					}else{
						dd('Problème : la ligne n° '.$numeroLigne.' de la commande id = '.$commande_old->id_commande.' présente la valeur : '.$valeur);
					}
				}
			}
		}
		return($lignes);
	}



	/**
	 * À partir du muméro de ligne, récupérer la quantité et le panier_id,
	 * les assigner à la nouvelle ligne et retourner celle-ci.
	 *
	 * @return void
	 * @author
	 **/
	private function recompositionLigne($numeroLigne, $commande_old)
	{
		$ligne = new Ligne;

		$NameColonneQuantite = 'ligne'.$numeroLigne.'_qte';
		$NameColonnePanier = 'ligne'.$numeroLigne.'_colis';


		$ligne->quantite = $commande_old->$NameColonneQuantite;
		$ligne->panier_id = $commande_old->$NameColonnePanier;

		return $ligne;
	}


	/**
	 * Il s'agit ici de créer un enregistrement dans panier_livraison lorsqu'une ligne d'une commande est créée,
	 * ce, pour persister le producteur et le prix livraison.
	 * Mais attention, plusieurs commandes d'une même livraison peuvent faire référence à un même couple panier/livraison.
	 * En ce cas on ne recrée pas un nouvel enregistrement pour conserver l'unicité des données en BDD.
	 *
	 **/
	function actualisePivotLivraisonPanier($lignes, $commande_old)
	{
		foreach ($lignes as $ligne) {
			$query = \DB::table('livraison_panier')->where([['livraison_id', '=', $commande_old->id_date], ['panier_id', '=', $ligne->panier_id]])->get();
			if (empty($query)) {
				\DB::table('livraison_panier')->insert([
					'livraison_id' => $commande_old->id_date,
					'panier_id' => $ligne->panier_id,
					'prix_livraison' => $this->getPrixFinal($ligne->panier_id, $commande_old)
					]);
			}
		}

	}



	private function getPrixFinal($panier_id, $commande_old)
	{
		$date = Carbon::createFromFormat('Y-m-d', '2017-09-05');
		$date_creation = Carbon::createFromFormat('Y-m-d', $commande_old->date_creation);

		if ($date->diffInDays($date_creation) > 0) {

			switch ($panier_id) {
				case '1':
				return 80.00;
				break;

				case '2':
				return 130.00;
				break;

				case '3':
				return 0;
				break;

				case '4':
				return 53.50;
				break;

				case '5':
				return 26.50;
				break;

				case '6':
				return 0;
				break;

				case '7':
				return 43.50;
				break;

				case '8':
				return 86.00;
				break;

				case '9':
				return 56.00;
				break;

				case '10':
				return 34.00;
				break;

				case '11':
				return 39.50;
				break;

				case '12':
				return 78.00;
				break;

				case '13':
				return 50.00;
				break;

				case '14':
				return 34.50;
				break;

				case '15':
				return 39.00;
				break;

				case '16':
				return 75.92;
				break;

				case '17':
				return 37.50;
				break;

				case '18':
				return 31.50;
				break;

				case '19':
				return 62.50;
				break;

				case '20':
				return 41.00;
				break;

				case '21':
				return 81.00;
				break;

				case '22':
				return 21.00;
				break;

				case '23':
				return 0;
				break;

				default:
				return 0;
				break;
			}

		}else{
			$panier = Panier::find($panier_id);
			return $panier->prix_base;
		}

	}

	/**
	 * Filtrer les dates, car, par erreur, au début de l'utilisation de l'ancienne base certaines dates ont été codées (D-m-Y) et non (Y-m-D)
	 *
	 * @return void
	 * @author
	 **/
	function checkAndReformateDate($date = '')
	{
		if ($date == '' || $date = '0000-00-00') {
			$date = date('Y-m-d', time());
		}else{
			$date = explode('-', $date);
			if( strlen($date[2]) == 4 ){
				$date = implode('-', [ $date[2], $date[1], $date[0] ]);
			}else{
				$date = implode('-', [ $date[0], $date[1], $date[2] ]);
			}
		}

		return $date;
	}
}
