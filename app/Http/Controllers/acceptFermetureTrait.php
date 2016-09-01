<?php

namespace App\Http\Controllers;

use App\Domaines\FermetureDomaine as Fermeture;

trait acceptFermetureTrait
{
    public function addFermeture($fermable_id, Fermeture $fermeture)
    {     
        $this->keepUrlDepart();

        /* Acquisition d'un modèle de fermeture, même vide, pour renseigner la variable $model du formulaire commun avec l'édition */
        $model = $fermeture->newModel();

        $fermable_model = $this->domaine->findFirst($fermable_id);
        $model->fermable_type = get_class($fermable_model);
        $model->fermable_nom = $fermable_model->nom;
        $model->fermable_id = $fermable_id;


        $titre_page = trans('titrepage.fermeture.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->fermable_nom]);

        return view('fermeture.create')->with(compact('model', 'titre_page'));
    }



    public function detachFermeture($fermable_id, Fermeture $fermeture, $forcage = false)
    {     
        $this->keepUrlDepart();

        /* Contrôle si le modèle fermable est directement lié à une livraison */
        /* Contrôle si le modèle fermable est indirectement lié à une livraison (via données dans la table pivot livraison-panier */

        $fermable_model = $this->domaine->findFirst($fermable_id);
        $model->fermable_type = get_class($fermable_model);
        $model->fermable_nom = $fermable_model->nom;
        $model->fermable_id = $fermable_id;


        $titre_page = trans('titrepage.fermeture.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->fermable_nom]);

        return view('fermeture.create')->with(compact('model', 'titre_page'));
    }

    /**
    * Conservation de l'url de la page de départ.
    * 
    **/
    private function keepUrlDepart(){
        if (!\Session::has('url_depart_ajout_fermeture')) {
            \Session::set('url_depart_ajout_fermeture', \Session::get('_previous.url'));
        }
    }

}
