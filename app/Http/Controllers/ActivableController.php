<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Domaines\PanierDomaine;

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
    	$domaine_class = ucfirst($model_class).'Domaine';
    	$domaine = new PanierDomaine;
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
    	$domaine_class = ucfirst($model_class).'Domaine';
    	$domaine = new PanierDomaine;
        return $domaine->desactive($id);
    }
}
