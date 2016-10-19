<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Http\Requests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $domaine;


    public function index()
    {
    	$critere_tri = (null !== $this->request->get('critere_tri'))? $this->request->get('critere_tri') : 'rang';
    	$sens_tri = (null !== $this->request->get('sens_tri'))? $this->request->get('sens_tri') : 'asc';

        $models = $this->domaine->all($critere_tri, $sens_tri);
        return view($this->domaine_name.'.index')->with(compact('models'));
    }



    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }


    /**
    * Conservation de l'url initiale.
    * 
    **/
    public function keepUrlInitiale(){
        if (!\Session::has('url_initiale')) {
            \Session::set('url_initiale', \Session::get('_previous.url'));
        }
    }



    /**
    * Récupération de l'url initiale et effacement en session.
    * 
    **/
    protected function getUrlInitiale(){
        return \Session::get('url_initiale', \Session::get('_previous.url'));
    }


}
