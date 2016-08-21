<?php

namespace App\Http\Controllers;

use App\Domaines\RelaisDomaine as Domaine;
use App\Http\Requests\RelaisRequest;
use App\Http\Controllers\getDeletedTrait;
use App\Http\Controllers\setRangsTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    use getDeletedTrait, setRangsTrait;

    private $domaine;
    private $entityName;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
        $this->entityName = 'relais';
    }


    public function index()
    {
    	$models = $this->domaine->index();
    	return view('relais.index')->with(compact('models'));
    }


    public function create()
    {
        $model =  $this->domaine->newModel();
        return view('relais.create')->with(compact('model'));
    }


    public function store(RelaisRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.relais.storefailed'));
        }
    }


    public function edit($id)
    {
    	$model = $this->domaine->findFirst($id);
    	return view('relais.edit')->with(compact('model'));
    }


    public function update($id, RelaisRequest $request)
    {
        $resultat = ($this->domaine->update($id, $request));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('relais.index')->with('success', trans('message.relais.updateOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.relais.updatefailed'));
        }
    }


    public function destroy($id)
    {     
        $resultat = ($this->domaine->destroy($id));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('relais.index')->with('success', trans('message.relais.deleteOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.relais.deletefailed'));
        }

    }


    public function addFermeture($id, \App\Domaines\FermetureDomaine $fermeture)
    {     
        /* Conservation de l'url de la page de départ */
        \Session::set('url_depart_ajout_fermeture', \Session::get('_previous.url'));

        /* Acquisition d'un modèle de fermeture, même vide, pour renseigner la variable $model du formulaire commun avec l'édition */
        $model = $fermeture->newModel();

        $fermable_model =  $this->domaine->findFirst($id);
        $fermable_type = get_class($fermable_model);
        $fermable_nom = $fermable_model->nom;
        $fermable_id = $id;


        $titre_page = trans('titrepage.fermeture.create', ['entity' => 'au '.$this->entityName, 'nom' => $fermable_nom]);

        return view('fermeture.create')->with(compact('model', 'titre_page', 'fermable_type', 'fermable_id'));
    }

}