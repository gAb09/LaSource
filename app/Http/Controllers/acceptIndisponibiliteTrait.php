<?php

namespace App\Http\Controllers;

use App\Domaines\IndisponibiliteDomaine as Indisponibilite;

trait acceptIndisponibiliteTrait
{
    public function addIndisponibilite($indisponible_id, Indisponibilite $indisponibilite)
    {     
        $this->keepUrlDepart();

        /* Acquisition d'un modèle d’indisponibilité, même vide, pour renseigner la variable $model du formulaire commun avec l'édition */
        $model = $indisponibilite->newModel();

        $indisponible_model = $this->domaine->findFirst($indisponible_id);
        $model->indisponible_type = get_class($indisponible_model);
        $model->indisponible_nom = $indisponible_model->nom;
        $model->indisponible_id = $indisponible_id;


        $titre_page = trans('titrepage.indisponibilite.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->indisponible_nom]);

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }



    public function detachIndisponibilite($indisponible_id, Indisponibilite $indisponibilite, $forcage = false)
    {     
        $this->keepUrlDepart();

        /* Contrôle si le modèle indisponible est directement lié à une livraison */
        /* Contrôle si le modèle indisponible est indirectement lié à une livraison (via données dans la table pivot livraison-panier */

        $indisponible_model = $this->domaine->findFirst($indisponible_id);
        $model->indisponible_type = get_class($indisponible_model);
        $model->indisponible_nom = $indisponible_model->nom;
        $model->indisponible_id = $indisponible_id;


        $titre_page = trans('titrepage.indisponibilite.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->indisponible_nom]);

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }

    /**
    * Conservation de l'url de la page de départ.
    * 
    **/
    private function keepUrlDepart(){
        if (!\Session::has('url_depart_ajout_indisponibilite')) {
            \Session::set('url_depart_ajout_indisponibilite', \Session::get('_previous.url'));
        }
    }

}
