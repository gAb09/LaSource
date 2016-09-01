<?php

namespace App\Http\Controllers;

use App\Domaines\FermetureDomaine as Fermeture;
use App\Domaines\Relais;
use App\Http\Requests\FermetureRequest;
use App\Http\Controllers\acceptFermetureTrait;

use Illuminate\Http\Request;

class FermetureController extends Controller
{
    use acceptFermetureTrait;

    private $domaine;
    private $entity;
    private $domainesPath = 'App\\Domaines\\';


    public function __construct(Fermeture $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('date_debut');
        return view('fermeture.index')->with(compact('models'));
    }


    public function store(FermetureRequest $request)
    {
        if ($this->domaine->store($request)) {
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.fermeture.storeOk') );
        }
        return redirect()->back()->with( 'status', trans('message.fermeture.storefailed').trans('message.bug.transmis') );
    }



    public function edit($id)
    {
        $model = $this->domaine->edit($id);
        $this->keepUrlDepart();
        $titre_page = trans('titrepage.fermeture.edit', ['nom' => $model->fermable_nom]);

        return view('fermeture.edit')->with(compact('model', 'titre_page'));
    }



    public function update($id, FermetureRequest $request)
    {
        if($this->domaine->update($id, $request)){
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.fermeture.updateOk') );
        }
        return redirect()->back()->with( 'status', trans('message.fermeture.updatefailed').trans('message.bug.transmis') );
    }



    public function destroy($id)
    {     
        if($this->domaine->destroy($id)){
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.fermeture.deleteOk') );
        }
        return redirect()->back()->with('status', trans('message.fermeture.deletefailed'));
    }


    /**
    * Récupération de l'url de la page de départ et effacement en session.
    * 
    **/
    private function getUrlDepart(){
        if (\Session::has('url_depart_ajout_fermeture')) {
            $url = \Session::get('url_depart_ajout_fermeture');
            \Session::forget('url_depart_ajout_fermeture');
            return $url;
        }else{
            return \Session::get('_previous.url');
        }
    }

}