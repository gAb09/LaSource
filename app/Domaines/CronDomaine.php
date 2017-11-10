<?php

namespace App\Domaines;

use App\Models\Livraison;
use App\Models\Commande;
use Gab\Helpers\DateFr;
use Carbon\Carbon;

class CronDomaine extends Domaine
{

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function ActualisationQuotidienne(){
		echo DateFr::avecHeurePourConsole(Carbon::now())."\n\n";

		$this->handleStatutLivraisonViaCron();
		echo "\n";
		$this->handleStatutCommandeViaCron();
		echo "\n\n";
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function handleStatutLivraisonViaCron(){
		$models = Livraison::whereNotIn('statut', $this->livraison_morte)->get();
		$txt = "";
		$models->each( function($item) {
			$txt = "livraison n° ".$item->id;
			$txt .= " (du ".DateFr::completePourConsole($item->date_livraison).') : ';
			$txt .= $item->statut."\n";
			echo $txt;

			$statut = $item->statut;
			$item->statut = $statut;

			$item->update();
		});
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function handleStatutCommandeViaCron(){
		$models = Commande::whereNotIn('statut', $this->commande_morte)->get();
		$models->each( function($item){
			$txt = "commande n° ".$item->numero;
			$txt .= " (du ".DateFr::completePourConsole($item->created_at).') : ';
			$txt .= $item->statut."\n";
			echo $txt;

			$statut = $item->statut;
			$item->statut = $statut;

			$item->update();
		});
	}


}