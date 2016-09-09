<?php

namespace App\Http\Controllers;

use App\Domaines\PanierDomaine as Domaine;
use App\Http\Requests\PanierRequest;
use App\Http\Controllers\getDeletedTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class PanierController extends Controller
{
    use getDeletedTrait;

    
    public function __construct(Domaine $domaine, Request $request)
    {
        $this->domaine = $domaine;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
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