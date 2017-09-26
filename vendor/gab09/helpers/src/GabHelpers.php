<?php namespace Gab\Helpers;

use Carbon\Carbon as Carbon;

class GabHelpers {
	

	/**
	 * All of the registered messages.
	 *
	 * @var array
	 */
	public static function listForSelect($model, $attribut, $scope = null, $defaut = true)
	{

// dd($model);
		if ($scope !== null) {
			$scope = 'scope'.$scope;
			$list = $model->$scope();

		}else{
			foreach($model->get(['id', $attribut]) as $item)
			{
				$list[$item->id] = $item->{$attribut};
			}
		}
		if ($defaut === true) {
			$list[0] = CREATE_FORM_DEFAUT_LIST;
		}

		return $list;
	}


	/* Date longue insécable
	**
	** return 15 décembre 1960 (espaces insécables)
	** e B Y 
	** 2 séparateurs = nbspace 
	*/
	public static function DatesFrlongue(Carbon $date){
		return $date->formatlocalized('%e&nbsp%B&nbsp%Y');
	}

	/* Date longue sécable
	**
	** return 15 décembre 1960 (espaces sécables)
	** e B Y 
	** 2 séparateurs = space
	*/
	public static function DatesFrlongueSec(Carbon $date){
		return $date->formatlocalized('%e %B %Y');
	}

	/* Pour permettre classement des écritures par années puis mois
	**
	** return 1960-12
	** Y m 
	** Séparateur = tiret
	*/
	public static function DatesFrclassAnMois(Carbon $date){
		return $date->formatlocalized('%Y.%m');
	}

	/* Mois année (Affichage en tétière de récapitulatif par mois)
	**
	** return décembre 1960
	** B Y
	** Séparateur = nbspace
	*/
	public static function DatesFrMoisAnneeInsec(Carbon $date){
		return ucfirst($date->formatlocalized('%B&nbsp%Y'));
	}

	/* Pour saisie dans les formulaires
	**
	** return 15-12-1960
	** d m Y 
	** Séparateur = tiret
	*/
	public static function DatesFrformEdit(Carbon $date){
		return $date->formatlocalized('%d-%m-%Y');
	}

	/* Pour sauvegarde
	**
	** return 15-12-1960
	** d m Y 
	** Séparateur = tiret
	*/
	public static function DatesFrSauv($date){
		if (substr_count($date, '-') == 2) {
			$parties = explode('-', $date);
			return $parties[2].'-'.$parties[1].'-'.$parties[0].' 00:00:00';
		}
	}

	/* Pour Affichage du mois en cours d'édition
	**
	** return décembre 1960
	** B Y
	** Séparateur = nbspace
	*/
	public static function DatesFrMoisEdit($string){
		if ($string and !is_string($string)) {
			throw new Exception("Une chaîne est attendue", 1);
			
		}

		try {
			if (substr_count($string, '.') == 1) {
				$parties = explode('.', $string);

			// dd($date = $parties[0].', '.$parties[1].', 01, 00, 00, 00');
				$date =  Carbon::create($parties[0], $parties[1], 01, 00 ,00, 00);
				return self::MoisAnneeInsec($date);
			}
		} catch (Exception $e) {
		}
	}

// – – – – – – – – – –  Constantes php pour les dates – – – – – – – – – – – – – – 
	/* d
	** Jour du mois en numérique, sur 2 chiffres (avec le zéro initial).
	** De 01 à 31
	*/

	/* e
	** Jour du mois, avec un espace précédant le premier chiffre.
	** De 1 à 31
	*/

	/* B
	** Nom du mois, complet, suivant la locale.
	** De janvier à décembre.
	*/

	/* b
	** Nom du mois, abrégé, suivant la locale.
	** De jan à déc.
	*/

	/* m
	** Mois, sur 2 chiffres.
	** De 01 (pour Janvier) à 12 (pour Décembre).
	*/

	/* Y
	** L’année, sur 4 chiffres.
	** Exemple : 2038
	*/


}
