<?php

namespace App\Http\Controllers;

use App\Domaines\FermetureDomaine as Fermeture;
use App\Http\Requests\FermetureRequest;

use Illuminate\Http\Request;

class FermetureController extends Controller
{
    private $domaine;
    private $modelName;
    private $modelsPath = "App\Models\\";
    
    public function __construct(Fermeture $domaine)
    {
        $this->domaine = $domaine;
        $this->modelName = 'fermeture';
    }


    public function index()
    {
        $models = $this->domaine->all('date_debut');
        return view('fermeture.index')->with(compact('models'));
    }


    public function create($fermable_modelName, $fermable_id)
    {
        \Session::set('page_depart', \Session::get('_previous.url'));
        $fermeture =  $this->domaine->create();
        $fermable_type = $this->modelsPath.ucfirst($fermable_modelName);
        $fermable_model = new $fermable_type;

        $fermable_nom = $fermable_model->where('id', $fermable_id)->first()->nom;
        $titre_page = trans('titrepage.fermeture.create', ['modelName' => $fermable_modelName, 'nom' => $fermable_nom]);
        // return ($fermable_model." : ".$fermable_id);

        return view('fermeture.create')->with(compact('titre_page', 'fermeture', 'fermable_type', 'fermable_id'));
    }

    public function store(Request $request)
    {
        if (!$this->domaine->store($request)) {
            return redirect()->back()->with( 'status', trans('message.fermeture.storefailed').trans('message.bug.transmis') );
        }
        // dd(\Session::get('page_depart'));
        $page_depart = \Session::get('page_depart');
        \Session::forget('page_depart');
        return redirect($page_depart)->with( 'success', trans('message.fermeture.storeOk') );
    }


}