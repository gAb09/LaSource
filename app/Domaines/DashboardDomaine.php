<?php

namespace App\Domaines;

use App\Domaines\Domaine;
use Carbon\Carbon;

class DashboardDomaine extends Domaine
{

	public function __construct(LivraisonDomaine $livraisonD, CommandeDomaine $commandeD, ProducteurDomaine $producteurD, RelaisDomaine $relaisD){
		$this->livraisonD = $livraisonD;
		$this->commandeD = $commandeD;
		$this->producteurD = $producteurD;
		$this->relaisD = $relaisD;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function getAllLivraisonsForDashboard()
	{
		$livraisons = $this->livraisonD->getAllLivraisonsOuvertes();
		if($livraisons == false){
			$this->message = 'Aucune livraison en cours';
			return false;
		}
		// return dd($livraisons);
		$livraisons->each(function($livraison){
			$livraison = $this->livraisonD->getRapportDashboard($livraison);
			$livraison->rapport_commandes = $this->commandeD->getRapportDashboard($livraison->id);
			$livraison->rapport_producteurs = $this->producteurD->getRapportDashboard($livraison->id);
			$livraison->rapport_relais = $this->relaisD->getRapportDashboard($livraison->id);
		});

		// return dd($livraisons);
		return $livraisons;
	}
}

        // $livraisons = $this->livraisonD->getLivraisonsRapportDashboard();
        // $commandes = $this->commandeD->getCommandesRapportDashboard();
        // return view('dashboard.main')->with(compact('livraisons', 'commandes', 'relais', 'producteurs', 'indispos'));
