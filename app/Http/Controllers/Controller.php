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
        return view($this->domaine_name.'.index')->with(compact('models'))->with('mode', 'index');
    }



    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }



    /**
    * Récupération des modèles soft deleted. On utilise la même vue que pour l'index.
    * C'est la variable $mode qui permettra à la vue de se configurer.
    * 
    * @return view
    **/
    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view($this->domaine->getDomaineName().'.index')->with(['models' => $models, 'mode' => 'trashed']);
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
        $url = \Session::get('url_initiale', \Session::get('_previous.url'));
        \Session::forget('url_initiale');
        return $url;
    }


    public function restore($id){
        if($this->domaine->restore($id)){
            return redirect()->route($this->domaine->getDomaineName().'.index')->with('success', trans('message.'.$this->domaine->getDomaineName().'.restoreOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }


}
