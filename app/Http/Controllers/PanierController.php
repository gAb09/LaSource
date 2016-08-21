<?php

namespace App\Http\Controllers;

use App\Domaines\PanierDomaine as Panier;
use App\Http\Requests\PanierRequest;
use App\Http\Controllers\getDeletedTrait;
use App\Http\Controllers\setRangsTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class PanierController extends Controller
{
    use getDeletedTrait, setRangsTrait;

    private $domaine;
    private $modelName;
    
    public function __construct(Panier $domaine)
    {
        $this->domaine = $domaine;
        $this->modelName = 'panier';
    }


    public function index()
    {
        $models = $this->domaine->all('rang');
        return view('panier.index')->with(compact('models'));
    }


    public function create()
    {
        $model =  $this->domaine->newModel();
        return view('panier.create')->with(compact('model'));
    }


    public function store(PanierRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('panier.index')->with('success', trans('message.panier.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.panier.storefailed'));
        }
    }


    public function edit($id)
    {
    	$model = $this->domaine->findFirst($id);
    	return view('panier.edit')->with(compact('model'));
    }


    public function update($id, PanierRequest $request)
    {
        $resultat = ($this->domaine->update($id, $request));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('panier.index')->with('success', trans('message.panier.updateOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.panier.updatefailed'));
        }
    }


    public function destroy($id)
    {     
        $resultat = ($this->domaine->destroy($id));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('panier.index')->with('success', trans('message.panier.deleteOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.panier.deletefailed'));
        }

    }


    public function syncProducteurs($panier, Request $request)
    {
        // dd($panier);
        // dd('syncProducteurs');
        // dd($request->input('resultat'));
        $this->domaine->PanierSyncProducteurs($panier, $request->input('resultat'));
        return redirect()->back();
    }

}