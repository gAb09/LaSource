<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use Carbon\Carbon;

class DashboardDomaine extends Domaine
{

	public function __construct(LivraisonDomaine $livraisonD, CommandeDomaine $commandeD){
		$this->livraisonD = $livraisonD;
		$this->commandeD = $commandeD;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function getallCollectionsForDashboard()
	{
		$collections = $this->livraisonD->getAllLivraisonsOuvertes();
		if($collections == false){
			$this->message = 'Aucune livraison en cours';
			return false;
		}
		// return dd($collections);
		$collections->each(function($collection){
			$collection = $this->livraisonD->getLivraisonRapportDashboard($collection);
			$collection->rapport_commandes = $this->commandeD->getCommandesRapportDashboard($collection->id);
			$collection->rapport_producteurs = [0 => 'commandes'];
			$collection->rapport_relais = [0 => 'commandes'];
		});

		// return dd($collections);
		return $collections;
	}
}

        // $livraisons = $this->livraisonD->getLivraisonsRapportDashboard();
        // $commandes = $this->commandeD->getCommandesRapportDashboard();
        // return view('dashboard.main')->with(compact('livraisons', 'commandes', 'relais', 'producteurs', 'indispos'));
