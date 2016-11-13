<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait handleIndisponibilitiesChangesTrait
{

    /**
    * Post-traitement du formulaire de gestion des livraisons concernées.
    *
    * @param integer $indisponisable_id
    * @param Illuminate\Http\Request $request
    * @return Redirect
    **/
    public function handleIndisponibilitiesChanges($indisponisable_id, Request $request)
    {
        // return dd($request->get('livraison_id'));//CTRL
    	if ($this->domaine->handleIndisponibilitiesChanges($indisponisable_id, $request)) {
    		return redirect($this->getUrlInitiale())->with('success', $this->domaine->getMessage());
    	}else{
    		return redirect($this->getUrlInitiale())->with('status', $this->domaine->getMessage());
    	}
    }
}

