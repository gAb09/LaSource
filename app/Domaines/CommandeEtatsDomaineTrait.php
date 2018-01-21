<?php

namespace App\Domaines;

use Carbon\Carbon;


trait CommandeEtatsDomaineTrait
{
    private $commandes_archived = array('C_ARCHIVED', 'C_ARCHIVABLE');

	/**
     * Non implémentée.
     * Prévoit la possibilté de fixer des conditions avant qu'une livraison créée puisse être ouverte,
     * (par exemple qu'un nombre minimum de commandes soit atteint).
     *
     * @var array
     */
	public function checkIfOkForOuverture()
	{
		if (1 == 1) {
			return true;
		}
	}


	public function getEtat($model)
	{
		$nouvel_etat = "C_CREATED";

		if ($this->checkIfOkForOuverture()) {
			$nouvel_etat = "C_REGISTERED";
		}

		/* date de clôture passée */
		if ($model->livraison->date_cloture->diffInDays(Carbon::today(), false) > 0) {
			$nouvel_etat = "C_CLOTURED";
		}

		/* date de paiement passée */
		if ($model->livraison->date_paiement->diffInDays(Carbon::today(), false) > 0) {
			if ($model->is_paid) {
				$nouvel_etat = 'C_PAID';
			}else{
				$nouvel_etat = 'C_NONPAID';
			}
		}

		/* date de livraison passée */
		if ($model->livraison->date_livraison->diffInDays(Carbon::today(), false) > 0) {
			if ($model->is_retired and $model->is_paid) {
				$nouvel_etat = 'C_ARCHIVABLE';
			}
			if (!$model->is_retired and $model->is_paid) {
				$nouvel_etat = 'C_OUBLIED';
			}
			if ($model->is_retired and !$model->is_paid) {
				$nouvel_etat = 'C_NONPAID';
			}
			if (!$model->is_retired and !$model->is_paid) {
				$nouvel_etat = 'C_SUSPECTED';
			}

		}

		if ($model->statut == 'C_ARCHIVED') {
			$nouvel_etat = "C_ARCHIVED";
		}

		return $nouvel_etat;

	}



	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isChangeAuthorized($model, $property)
	{
		switch ($property) {
			case 'is_paid':
			if ($model->is_paid == true) {
				return $this->isUnsetPaidAuthorized($model);
			}else{
				return $this->isSetPaidAuthorized($model);
			}
			break;
			
			case 'is_livred':
			if ($model->is_livred == true) {
				return $this->isUnsetLivredAuthorized($model);
			}else{
				return $this->isSetLivredAuthorized($model);
			}
			break;
			
			case 'is_retired':
			if ($model->is_retired == true) {
				return $this->isUnsetRetiredAuthorized($model);
			}else{
				return $this->isSetRetiredAuthorized($model);
			}
			break;
			
			default:
			$this->message = "Problème, l'application bascule en mode par défaut…";
			return false;
			break;
		}
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isUnsetPaidAuthorized($model)
	{
		$this->message = "Impossible de déclarer la commande impayée";
		return true;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isSetPaidAuthorized($model)
	{
		$this->message = "Impossible de déclarer la commande payée";
		return true;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isUnsetLivredAuthorized($model)
	{
		if (!$this->isDateLivraisonAtteinte($model)) {
			return false;
		} 
		if ($model->is_retired == 1) {
			$this->message = "Attention : cette commande est notée “retirée”, elle est donc forcément livrée";
			return false;
		} 
		return true;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isSetLivredAuthorized($model)
	{
		if (!$this->isDateLivraisonAtteinte($model)) {
			return false;
		} 
		return true;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isUnsetRetiredAuthorized($model)
	{
		if (!$this->isDateLivraisonAtteinte($model)) {
			return false;
		} 
		return true;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isSetRetiredAuthorized($model)
	{
		if (!$this->isDateLivraisonAtteinte($model)) {
			return false;
		} 
		if ($model->is_livred == 0) {
			$this->message = "Attention : si cette commande n’a pas été livrée, elle ne peut pas être retirée";
			return false;
		} 
		return true;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function isDateLivraisonAtteinte($model)
	{
		if ($model->livraison->date_livraison->diffInDays(Carbon::today(), false) >= 0) {
			return true;
		}else{
			$this->message = "La date de livraison n’est pas encore atteinte";
			return false;
		}
	}
}
