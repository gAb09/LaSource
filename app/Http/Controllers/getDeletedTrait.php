<?php
namespace App\Http\Controllers;

trait getDeletedTrait
{

    /**
    * Récupération des modèles soft deleted. On utilise la même vue que pour l'index.
    * C'est la variable $trashed qui permettra à la vue de se configurer.
    * 
    * @return string
    **/
    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view($this->domaine->getDomaineName().'.trashed')->with(['models' => $models, 'trashed' => 'trashed']);
    }
}
