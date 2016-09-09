<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndisponibiliteRequest;
use App\Domaines\IndisponibiliteDomaine as Indisponibilite;

use Illuminate\Http\Request;

class IndisponibiliteController extends Controller
{

    protected $domaine;
    private $entity;
    private $domainesPath = 'App\\Domaines\\';


    public function __construct(Indisponibilite $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('date_debut');
        return view('indisponibilite.index')->with(compact('models'));
    }


    public function addIndisponibilite($indisponible_classe, $indisponible_id)
    {     
        $this->domaine->keepUrlDepart();

        $model = $this->domaine->addIndisponibilite($indisponible_classe, $indisponible_id);

        $titre_page = trans('titrepage.indisponibilite.create', ['entity' => 'au '.$indisponible_classe, 'nom' => $model->indisponible_nom]);

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }



    public function store(IndisponibiliteRequest $request)
    {
        if ($this->domaine->store($request)) {
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.indisponibilite.storeOk') );
        }
        return redirect()->back()->with( 'status', trans('message.indisponibilite.storefailed').trans('message.bug.transmis') );
    }



    public function edit($id)
    {
        $model = $this->domaine->edit($id);
        $this->domaine->keepUrlDepart();
        $titre_page = trans('titrepage.indisponibilite.edit', ['nom' => $model->indisponible_nom]);

        return view('indisponibilite.edit')->with(compact('model', 'titre_page'));
    }



    public function update($id, IndisponibiliteRequest $request)
    {
        if($this->domaine->update($id, $request)){
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.indisponibilite.updateOk') );
        }
        return redirect()->back()->with( 'status', trans('message.indisponibilite.updatefailed').trans('message.bug.transmis') );
    }



    public function destroy($id)
    {     
        if($this->domaine->destroy($id)){
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.indisponibilite.deleteOk') );
        }
        return redirect()->back()->with('status', trans('message.indisponibilite.deletefailed'));
    }


    /**
    * Récupération de l'url de la page de départ et effacement en session.
    * 
    **/
    private function getUrlDepart(){
        if (\Session::has('url_depart_ajout_indisponibilite')) {
            $url = \Session::get('url_depart_ajout_indisponibilite');
            \Session::forget('url_depart_ajout_indisponibilite');
        }else{
            $url = \Session::get('_previous.url');
        }
        return $url;
    }

}