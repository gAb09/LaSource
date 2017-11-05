<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Domaines\PanierDomaine;
use App\Domaines\ProducteurDomaine;

class ActivableController extends Controller
{
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function active($model_class, $id)
    {
        $domaine_class = 'App\\Domaines\\'.ucfirst($model_class).'Domaine';
    	$domaine = new $domaine_class;
        return $domaine->active($id);
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function desactive($model_class, $id)
    {
    	$domaine_class = 'App\\Domaines\\'.ucfirst($model_class).'Domaine';
    	$domaine = new $domaine_class;
        return $domaine->desactive($id);
    }
}
