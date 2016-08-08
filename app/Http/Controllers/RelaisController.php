<?php

namespace App\Http\Controllers;

use App\Domaines\RelaisDomaine as Domaine;
use App\Http\Requests\RelaisRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
    	$models = $this->domaine->all();
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
    	$model = $this->domaine->findFirst('id', $id);
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


    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view('relais.trashed')->with(compact('models', 'trashed'));
    }

    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }


}