<?php

namespace App\Http\Controllers;

use App\Domaines\PanierDomaine as Domaine;
use App\Http\Requests\PanierRequest;
use App\Http\Controllers\getDeletedTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class PanierController extends Controller
{
    
    public function __construct(Domaine $domaine, Request $request)
    {
        $this->domaine = $domaine;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
    }



    public function create()
    {
        $model =  $this->domaine->getCurrentModel();
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
        $this->keepUrlInitiale();
    	$model = $this->domaine->findFirstWithTrashed($id);
        
    	return view('panier.edit')->with(compact('model'));
    }



    public function update($id, PanierRequest $request)
    {
        $url_back = $this->getUrlInitiale();
        if($this->domaine->update($id, $request)){
            return redirect($url_back)->with('success', trans('message.panier.updateOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }


    public function destroy($id)
    {     
        if($this->domaine->destroyAfterVerif($id)){
            return redirect()->route('panier.index')->with('success', trans('message.panier.deleteOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
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