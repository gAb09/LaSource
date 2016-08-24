<?php

namespace App\Http\Controllers;


trait addFermetureTrait
{
    public function addFermeture($id, \App\Domaines\FermetureDomaine $fermeture)
    {     
        /* Conservation de l'url de la page de départ */
        \Session::set('url_depart_ajout_fermeture', \Session::get('_previous.url'));

        /* Acquisition d'un modèle de fermeture, même vide, pour renseigner la variable $model du formulaire commun avec l'édition */
        $model = $fermeture->newModel();

        $fermable_model = $this->domaine->findFirst($id);
        $model->fermable_type = get_class($fermable_model);
        $model->fermable_nom = $fermable_model->nom;
        $model->fermable_id = $id;


        $titre_page = trans('titrepage.fermeture.create', ['entity' => 'au '.$this->entityName, 'nom' => $model->fermable_nom]);

        return view('fermeture.create')->with(compact('model', 'titre_page'));
    }

}
