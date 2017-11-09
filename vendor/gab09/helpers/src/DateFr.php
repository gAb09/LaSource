<?php namespace Gab\Helpers;

use Carbon\Carbon as Carbon;

class DateFr {
	
// – – – – – – – – – –  tokens php pour les dates – – – – – – – – – – – – – – 
	/* A
	** Jour du mois en lettre.
	*/

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



	/* Date complete insécable
	**
	** return Jeudi 15 décembre 1960 (espaces insécables)
	** e B Y 
	** 2 séparateurs = nbspace 
	*/
	public static function complete(Carbon $date){
		if(!($date instanceof Carbon)){
			throw new Exception("La date n'est pas un objet Carbon", 1);
			
		}
		return $date->formatlocalized('%A&nbsp;%e&nbsp;%B&nbsp;%Y');
	}

	public static function completePourConsole(Carbon $date){
		setlocale(LC_TIME, 'fr_FR');
		if(!($date instanceof Carbon)){
			throw new Exception("La date n'est pas un objet Carbon", 1);
			
		}
		return $date->formatlocalized('%A %e %B %Y');
	}

	public static function avecHeurePourConsole(Carbon $date){
		setlocale(LC_TIME, 'fr_FR');
		if(!($date instanceof Carbon)){
			throw new Exception("La date n'est pas un objet Carbon", 1);
			
		}
		return $date->formatlocalized("%A %e %B %Y - %Hh %i");
	}

}
