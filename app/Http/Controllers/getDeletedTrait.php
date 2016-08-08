<?php
namespace App\Http\Controllers;

trait getDeletedTrait
{
    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view($this->modelName.'.trashed')->with(['models' => $models, 'trashed' => 'trashed']);
    }
}
